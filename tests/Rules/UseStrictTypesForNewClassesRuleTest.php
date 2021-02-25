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
use PHPStanForPrestaShop\Rules\UseStrictTypesForNewClassesRule;

class UseStrictTypesForNewClassesRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $configurationLoader = new ArrayConfigurationLoader(['B', 'PHPStanForPrestaShopTests\Data\UseStrictTypesForNewClasses\B']);

        return new UseStrictTypesForNewClassesRule($configurationLoader);
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../Data/UseStrictTypesForNewClasses/';

        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassA.php'], [
            [
                'Class should declare strict type.',
                11,
            ],
        ]);
        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassSpaceA.php'], [
            [
                'Class should declare strict type.',
                11,
            ],
        ]);
        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassB.php'], []
        );
        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassSpaceB.php'], []
        );
        $this->analyse(
            [$dataDirectory . 'DeclareStrictTypeClassC.php'], []
        );
    }
}
