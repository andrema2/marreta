<?php

declare(strict_types=1);

namespace Tests\Unit;

use Inc\Rules;
use PHPUnit\Framework\TestCase;

final class RulesTest extends TestCase
{
    public function test_subdomain_inherits_globo_rules_including_contains_element_remove(): void
    {
        $rules = new Rules();

        $domainRules = $rules->getDomainRules('valor.globo.com');

        $this->assertArrayHasKey('containsElementRemove', $domainRules);
        $this->assertContains('paywall', $domainRules['containsElementRemove']);
        $this->assertContains('piano', $domainRules['containsElementRemove']);
    }

    public function test_has_domain_rules_returns_true_for_globo_subdomain(): void
    {
        $rules = new Rules();

        $this->assertTrue($rules->hasDomainRules('valor.globo.com'));
    }

    public function test_valor_globo_has_expected_piano_rules(): void
    {
        $rules = new Rules();
        $domainRules = $rules->getDomainRules('valor.globo.com');

        $this->assertArrayHasKey('idElementRemove', $domainRules);
        $this->assertContains('paywall-desktop', $domainRules['idElementRemove']);

        $this->assertArrayHasKey('classElementRemove', $domainRules);
        $this->assertContains('wall', $domainRules['classElementRemove']);
        $this->assertContains('protected-content', $domainRules['classElementRemove']);
        $this->assertContains('hide-all-content', $domainRules['classElementRemove']);
        $this->assertContains('fade-top', $domainRules['classElementRemove']);

        $this->assertArrayHasKey('scriptTagRemove', $domainRules);
        $this->assertContains('static.infoglobo.com.br/paywall/js/tiny.js', $domainRules['scriptTagRemove']);
        $this->assertContains('experience.tinypass.com/xbuilder/experience/load?aid=VnaP3rYVKc', $domainRules['scriptTagRemove']);

        $this->assertArrayHasKey('cookiePrefixRemove', $domainRules);
        $this->assertContains('__utp', $domainRules['cookiePrefixRemove']);
        $this->assertContains('_pc_', $domainRules['cookiePrefixRemove']);
    }
}
