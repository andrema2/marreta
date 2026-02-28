<?php

declare(strict_types=1);

namespace Tests\Unit;

use Inc\URLAnalyzer;
use Inc\URLAnalyzer\URLAnalyzerException;
use PHPUnit\Framework\TestCase;

final class URLAnalyzerTest extends TestCase
{
    public function test_valor_hard_paywall_throws_content_error_when_text_is_too_short(): void
    {
        $analyzer = new class extends URLAnalyzer {
            public function validateValorContentForTest(string $host, string $processedContent): void
            {
                $this->validateHardPaywallForValor($host, $processedContent);
            }
        };

        try {
            $analyzer->validateValorContentForTest('valor.globo.com', '<html><body><p>Lead curto apenas.</p></body></html>');
            $this->fail('Expected URLAnalyzerException to be thrown for hard paywall content.');
        } catch (URLAnalyzerException $e) {
            $this->assertSame(URLAnalyzer::ERROR_CONTENT_ERROR, $e->getErrorType());
            $this->assertSame(502, $e->getCode());
            $this->assertStringContainsString('exclusivo para assinantes', $e->getMessage());
        }
    }

    public function test_valor_hard_paywall_does_not_throw_when_text_is_long_enough(): void
    {
        $analyzer = new class extends URLAnalyzer {
            public function validateValorContentForTest(string $host, string $processedContent): void
            {
                $this->validateHardPaywallForValor($host, $processedContent);
            }
        };

        $content = '<html><body><p>' . str_repeat('Conteudo suficiente para liberar leitura. ', 10) . '</p></body></html>';
        $analyzer->validateValorContentForTest('valor.globo.com', $content);
        $this->assertTrue(true);
    }

    public function test_non_valor_domains_are_not_checked_for_hard_paywall(): void
    {
        $analyzer = new class extends URLAnalyzer {
            public function validateValorContentForTest(string $host, string $processedContent): void
            {
                $this->validateHardPaywallForValor($host, $processedContent);
            }
        };

        $analyzer->validateValorContentForTest('globo.com', '<html><body><p>curto</p></body></html>');
        $this->assertTrue(true);
    }
}
