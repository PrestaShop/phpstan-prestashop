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
use PHPStanForPrestaShop\Rules\UseTypedReturnForNewMethodsRule;

class UseTypedReturnForNewMethodsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $configurationLoader = new ArrayConfigurationLoader(['D::bar', 'Space\E::bar']);

        return new UseTypedReturnForNewMethodsRule($configurationLoader);
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../data/';

        $this->analyse(
            [$dataDirectory . 'MethodFooAWithoutReturnType.php'], [
            [
                'Function foo should declare return type.',
                13,
            ],
        ]);
        $this->analyse([$dataDirectory . 'MethodFooBWithReturnType.php'], []);
        $this->analyse([$dataDirectory . 'MethodFooCWithNullableReturnType.php'], []);
        $this->analyse([$dataDirectory . 'MethodBarEWithoutReturnType.php'], []);
    }
}
