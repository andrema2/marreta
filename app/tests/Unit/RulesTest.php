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
}
