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
use PHPStanForPrestaShop\Rules\UseTypeHintForNewMethodsRule;

class UseTypeHintForNewMethodsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $configurationLoader = new ArrayConfigurationLoader([
            'D::bar',
            'PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods\MethodFooGWithoutTypeHintButExcluded::foo',
            'PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods\F::foo',
        ]);

        return new UseTypeHintForNewMethodsRule($configurationLoader, new PhpDocAnalyzer());
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../Data/UseTypeHintForNewMethods/';

        $this->analyse(
            [$dataDirectory . 'MethodFooAWithoutTypeHint.php'], [
            [
                'Every parameter of function foo should be type hinted (untyped parameters: a, z).',
                13,
            ],
        ]);

        $this->analyse([$dataDirectory . 'MethodFooBOneParameterWithTypeHint.php'], []);

        $this->analyse(
            [$dataDirectory . 'MethodFooCOneParameterWithTypeHintAndOneWithout.php'], [
            [
                'Every parameter of function foo should be type hinted (untyped parameters: d).',
                13,
            ],
        ]);

        $this->analyse([$dataDirectory . 'MethodFooDFourParametersWithScalarTypeHint.php'], []);
        $this->analyse([$dataDirectory . 'MethodFooEThreeParametersWithIdentifierTypeHint.php'], []);
        $this->analyse([$dataDirectory . 'MethodFooGWithoutTypeHintButExcluded.php'], []);
        $this->analyse([$dataDirectory . 'MethodFooHWithoutTypeHintButExtendsAnExcludedClass.php'], []);

        $this->analyse(
            [$dataDirectory . 'InterfaceFooIWithoutTypeHint.php'], [
            [
                'Every parameter of function foo should be type hinted (untyped parameters: a, b).',
                15,
            ],
        ]);
        $this->analyse([$dataDirectory . 'ClassWithConstructAndGetSet.php'], []);
        $this->analyse([$dataDirectory . 'MethodWithInheritPhpDoc.php'], []);
    }
}
