<?php declare(strict_types=1);

namespace PHPStanForPrestaShopTests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader;
use PHPStanForPrestaShop\Rules\UseStrictTypesForNewClassesRule;

class UseStrictTypesForNewClassesRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        $configurationLoader = new ArrayConfigurationLoader(['B', 'Space\B']);

        return new UseStrictTypesForNewClassesRule($configurationLoader);
    }

    public function testRule(): void
    {
        $dataDirectory = __DIR__ . '/../data/';

        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassA.php'], [
            [
                'Class should declare strict type.',
                3,
            ],
        ]);
        $this->analyse(
            [$dataDirectory . 'NoDeclareStrictTypeClassSpaceA.php'], [
            [
                'Class should declare strict type.',
                5,
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
