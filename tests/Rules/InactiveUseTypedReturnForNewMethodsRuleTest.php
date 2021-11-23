<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShopTests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader;
use PHPStanForPrestaShop\PhpDoc\PhpDocAnalyzer;
use PHPStanForPrestaShop\Rules\UseTypedReturnForNewMethodsRule;

class InactiveUseTypedReturnForNewMethodsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new UseTypedReturnForNewMethodsRule(
            new ArrayConfigurationLoader([]),
            new PhpDocAnalyzer(),
            false
        );
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../Data/UseTypedReturnForNewMethods/';

        $this->analyse([$dataDirectory . 'MethodFooAWithoutReturnType.php'], []);
    }
}