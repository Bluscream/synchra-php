#!/usr/bin/env python3
"""Turn captured API responses into committable fixtures.

Shape, keys and enum values are what the hydration tests assert on, so those are kept exactly.
Anything that identifies a person or a channel is replaced with a deterministic placeholder: real
ids, handles, display names, avatar URLs, e-mail addresses and chat message text never reach the
repository.
"""
import hashlib
import json
import re
import sys

HAR = '.references/dash.synchra.net_Archive [26-10-04 23-07-43].har'
OUT = 'tests/Fixtures'

WANT = {
    'GET user': 'user.json',
    'GET user/settings': 'user-settings.json',
    'GET user/providers': 'user-providers.json',
    'GET user/profiles': 'user-profiles.json',
    'GET channels': 'channels-page.json',
    'GET activity-types': 'activity-types.json',
    'GET chat/emotes': 'chat-emotes.json',
}
SUFFIX = {
    'activities': 'activities-page.json',
    'chat-messages': 'chat-messages-page.json',
    'chat-events': 'chat-events-page.json',
    'providers': 'channel-providers.json',
    'provider-streams': 'provider-streams-page.json',
    'activity-alerts/state': 'activity-alerts-state.json',
}

UUID_RE = re.compile(r'\b[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}\b', re.I)

# Anything that names a human or points at their picture. These capture real third-party viewers
# who never agreed to appear in a test suite, so the match has to be greedy rather than exact.
NAME_RE = re.compile(
    r'(^|_)(name|names|display_name|username|user_name|login|nickname|handle|slug|'
    r'first_name|last_name|full_name|author|broadcaster|chatter|viewer|sender|recipient)$'
)
URL_RE = re.compile(r'(url|uri|picture|avatar|image|thumbnail|logo|banner|icon|photo)$')
# Provider-side identifiers are stable handles for a person on Twitch/TikTok/YouTube.
FOREIGN_ID_RE = re.compile(r'^(provider|external|platform)_[a-z_]*id$|^(viewer|chatter|author)_id$')
TEXT_RE = re.compile(r'^(text|content|body|comment|raw|reply_text|fragment)$')
SECRET_RE = re.compile(
    r'(token|secret|password|api_key|signature|authorization|credential|email|'
    r'phone|address|ip_address)'
)
# Keys whose value is prose written by a person rather than by the API.
PROSE_KEYS = {'message'}

uuids = {}


def fake_uuid(value: str) -> str:
    if value not in uuids:
        digest = hashlib.sha256(f'synchra-fixture:{len(uuids)}'.encode()).hexdigest()
        uuids[value] = '-'.join([
            digest[0:8], digest[8:12], '7' + digest[13:16], 'a' + digest[17:20], digest[20:32],
        ])
    return uuids[value]


def scrub_string(value: str) -> str:
    # Third-party CDN links carry signed query strings and sometimes an account id, so every
    # off-Synchra URL is replaced wherever it appears, whatever the key around it is called.
    if value.startswith(('http://', 'https://')) and '//synchra.net' not in value \
            and '.synchra.net' not in value:
        return 'https://example.invalid/placeholder.png'

    return UUID_RE.sub(lambda m: fake_uuid(m.group(0).lower()), value)


def placeholder(prefix: str, value: str) -> str:
    return prefix + hashlib.sha256(value.encode()).hexdigest()[:8]


def scrub(node, key=None, depth=0, siblings=frozenset()):
    if isinstance(node, dict):
        out = {}
        keys = frozenset(k.lower() for k in node)

        for k, v in node.items():
            lower = k.lower()

            if not isinstance(v, str) or v == '':
                out[k] = scrub(v, k, depth + 1, keys)
            elif SECRET_RE.search(lower):
                out[k] = 'redacted'
            elif URL_RE.search(lower) and v.startswith('http'):
                out[k] = 'https://example.invalid/placeholder.png'
            elif NAME_RE.search(lower):
                out[k] = placeholder('example_', v)
            elif FOREIGN_ID_RE.search(lower):
                out[k] = placeholder('pid_', v)
            elif TEXT_RE.search(lower):
                out[k] = 'Example text.'
            # An API error's `message` is the server's own wording and worth keeping; a chat
            # object's `message` is something a person typed and is not.
            elif lower in PROSE_KEYS and not {'code', 'type'}.issubset(keys):
                out[k] = 'Example text.'
            else:
                out[k] = scrub(v, k, depth + 1, keys)

        return out
    if isinstance(node, list):
        # Two records prove list hydration; a hundred only bloats the repository.
        limited = node[:2] if key in ('records', 'lookup_data') else node[:8]
        return [scrub(v, key, depth + 1, siblings) for v in limited]
    if isinstance(node, str):
        return scrub_string(node)
    return node


def main() -> int:
    har = json.load(open(HAR))
    picked = {}

    for entry in har['log']['entries']:
        url = entry['request']['url']
        if '/api/2/' not in url:
            continue
        content = entry['response'].get('content') or {}
        if 'json' not in (content.get('mimeType') or '') or not content.get('text'):
            continue
        try:
            body = json.loads(content['text'])
        except json.JSONDecodeError:
            continue

        path = url.split('/api/2/', 1)[1].split('?')[0]
        key = f"{entry['request']['method']} {path}"
        name = WANT.get(key)

        if name is None:
            for suffix, candidate in SUFFIX.items():
                if path.endswith('/' + suffix) and entry['request']['method'] == 'GET':
                    name = candidate
                    break

        if name is None and entry['response']['status'] == 400:
            name = 'error-validation.json'

        if name is None:
            continue

        # Several calls hit the same endpoint; the richest response is the one worth keeping,
        # because an empty `records` list proves nothing about hydration.
        if name in picked and len(content['text']) <= picked[name][3]:
            continue

        picked[name] = (body, entry['response']['status'], key, len(content['text']))

    for name, (body, status, key, _) in sorted(picked.items()):
        scrubbed = scrub(body)
        with open(f'{OUT}/{name}', 'w') as handle:
            json.dump(scrubbed, handle, indent=2, sort_keys=False)
            handle.write('\n')
        print(f'{name:34} {status}  from {key}')

    leftovers = [n for n in set(WANT.values()) | set(SUFFIX.values()) if n not in picked]
    if leftovers:
        print('missing:', leftovers, file=sys.stderr)
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
