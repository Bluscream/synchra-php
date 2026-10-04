<?php

declare(strict_types=1);

namespace Synchra\Tests\Unit\Http;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Synchra\Enum\Provider;
use Synchra\Exception\ConfigurationException;
use Synchra\Http\Path;

#[CoversClass(Path::class)]
final class PathTest extends TestCase
{
    public function testPlaceholdersAreFilledFromTheirNames(): void
    {
        self::assertSame(
            '/channels/abc/providers/def/stream',
            Path::expand('/channels/{channel_id}/providers/{channel_provider_id}/stream', [
                'channel_id' => 'abc',
                'channel_provider_id' => 'def',
            ]),
        );
    }

    public function testASlashInAValueCannotEscapeItsSegment(): void
    {
        // Without encoding, `../admin` would address a different endpoint entirely.
        self::assertSame(
            '/kv/..%2Fadmin',
            Path::expand('/kv/{key}', ['key' => '../admin']),
        );
    }

    public function testEnumsAndIntegersAreAccepted(): void
    {
        self::assertSame('/x/twitch/7', Path::expand('/x/{provider}/{n}', [
            'provider' => Provider::Twitch,
            'n' => 7,
        ]));
    }

    public function testAMissingValueNamesThePlaceholderAndTheTemplate(): void
    {
        $this->expectException(ConfigurationException::class);
        $this->expectExceptionMessage('channel_id');

        Path::expand('/channels/{channel_id}', []);
    }

    public function testAnEmptyValueIsRefusedBecauseItWouldCollapseTheSegment(): void
    {
        $this->expectException(ConfigurationException::class);

        Path::expand('/channels/{channel_id}', ['channel_id' => '']);
    }

    public function testATemplateWithoutPlaceholdersIsReturnedUnchanged(): void
    {
        self::assertSame('/user/settings', Path::expand('/user/settings'));
    }

    public function testExtraValuesAreIgnoredRatherThanAppended(): void
    {
        self::assertSame('/x/1', Path::expand('/x/{a}', ['a' => 1, 'unused' => 2]));
    }
}
