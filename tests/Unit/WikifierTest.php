<?php

namespace Tests\Unit;

use App\Services\Wikifier;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WikifierTest extends TestCase
{
    private Wikifier $wikifier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->wikifier = new Wikifier;
    }

    #[DataProvider('routeLinkProvider')]
    public function test_route_links_are_parsed_individually(string $input, string $expectedHtml): void
    {
        $this->assertSame($expectedHtml, $this->wikifier->toHtml($input));
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function routeLinkProvider(): array
    {
        return [
            'single route link' => [
                '{/tools|Utilities}',
                '<p><a href="/tools">Utilities</a></p>'."\n",
            ],
            'two route links on one line' => [
                '{/services|Services overview} and {/tools|Utilities}',
                '<p><a href="/services">Services overview</a> and <a href="/tools">Utilities</a></p>'."\n",
            ],
            'two route links in a list' => [
                "* {/services|Services overview} — DNS lookup\n* {/tools|Utilities} — sysadmin tools",
                '<p>* <a href="/services">Services overview</a> — DNS lookup<li><a href="/tools">Utilities</a> — sysadmin tools</li></p>'."\n",
            ],
        ];
    }

    public function test_external_links_are_parsed_individually(): void
    {
        $html = $this->wikifier->toHtml('[https://a.com|Link A] and [https://b.com|Link B]');

        $this->assertStringContainsString('<a href="https://a.com" class="external">Link A</a>', $html);
        $this->assertStringContainsString('<a href="https://b.com" class="external">Link B</a>', $html);
    }

    public function test_double_asterisk_makes_bold(): void
    {
        $html = $this->wikifier->toHtml('**bold text**');

        $this->assertSame('<p><strong>bold text</strong></p>'."\n", $html);
    }

    public function test_double_asterisk_bold_can_wrap_external_links(): void
    {
        $html = $this->wikifier->toHtml('**See [https://example.com|Example]**');

        $this->assertStringContainsString('<strong>See <a href="https://example.com" class="external">Example</a></strong>', $html);
    }

    public function test_multiple_double_asterisk_bold_sections(): void
    {
        $html = $this->wikifier->toHtml('**first** and **second**');

        $this->assertSame('<p><strong>first</strong> and <strong>second</strong></p>'."\n", $html);
    }
}
