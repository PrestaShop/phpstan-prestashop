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
use PHPStanForPrestaShop\Rules\ClassConstantsMustHaveVisibilityRule;
use PHPStanForPrestaShop\Rules\UseStrictTypesForNewClassesRule;

class ClassConstantsMustHaveVisibilityRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new ClassConstantsMustHaveVisibilityRule();
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../Data/ClassConstantsMustHaveVisibility/';

        $this->analyse(
            [$dataDirectory . 'ClassAWithUnscopedConstant.php'], [
            [
                'Class constant FOO must declare a visibility',
                13,
            ],
        ]);
        $this->analyse(
            [$dataDirectory . 'ClassBWithPublicConstant.php'], []
        );
        $this->analyse(
            [$dataDirectory . 'ClassCWithPrivateConstant.php'], []
        );
        $this->analyse(
            [$dataDirectory . 'ClassDWithProtectedConstant.php'], []
        );
    }
}
