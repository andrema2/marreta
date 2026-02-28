<?php

declare(strict_types=1);

namespace Tests\Unit;

use Inc\URLAnalyzer\URLAnalyzerProcess;
use PHPUnit\Framework\TestCase;

final class URLAnalyzerProcessTest extends TestCase
{
    public function test_process_content_removes_elements_by_contains_rule(): void
    {
        $process = new class extends URLAnalyzerProcess {
            public function __construct()
            {
                // Intentionally bypass parent constructor to keep unit test isolated
            }

            protected function getDomainRules($domain)
            {
                return [
                    'containsElementRemove' => ['paywall', 'piano']
                ];
            }
        };

        $html = $this->buildHtml(
            '<div class="content">ok</div>'
            . '<div class="article-paywall-wrapper">hidden</div>'
            . '<section id="piano-overlay">overlay</section>'
        );

        $result = $process->processContent($html, 'valor.globo.com', 'https://valor.globo.com/a');

        $this->assertStringContainsString('class="content"', $result);
        $this->assertStringNotContainsString('article-paywall-wrapper', $result);
        $this->assertStringNotContainsString('piano-overlay', $result);
    }

    public function test_process_content_accepts_string_custom_code_and_custom_style(): void
    {
        $process = new class extends URLAnalyzerProcess {
            public function __construct()
            {
                // Intentionally bypass parent constructor to keep unit test isolated
            }

            protected function getDomainRules($domain)
            {
                return [
                    'customStyle' => '.paywall { display: none; }',
                    'customCode' => 'window.__marreta_test = true;'
                ];
            }
        };

        $html = $this->buildHtml('<div class="content">ok</div>');
        $result = $process->processContent($html, 'valor.globo.com', 'https://valor.globo.com/a');

        $this->assertStringContainsString('.paywall { display: none; }', $result);
        $this->assertStringContainsString('window.__marreta_test = true;', $result);
    }

    private function buildHtml(string $body): string
    {
        return '<!doctype html><html><head><title>T</title></head><body>'
            . $body
            . '<!-- ' . str_repeat('x', 5200) . ' -->'
            . '</body></html>';
    }
}
