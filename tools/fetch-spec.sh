#!/usr/bin/env bash
# Refresh the vendored API description from the live service, then regenerate.
#
# The OpenAPI document and the WebSocket reference are the only sources of truth for the
# generated layer, so they are vendored here: a build must not depend on the network, and a
# `git diff` after a refresh shows exactly how the API changed.
set -euo pipefail

host="${SYNCHRA_API_HOST:-https://api.synchra.net}"
root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"

curl --fail --show-error --silent "$host/openapi.json" \
    | php -r 'echo json_encode(json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), "\n";' \
    > "$root/spec/openapi.json"

curl --fail --show-error --silent "$host/api/2/ws-docs" > "$root/spec/websocket.md"

echo "Fetched $host into spec/. Run 'composer generate' to rebuild the generated layer."
