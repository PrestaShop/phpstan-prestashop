<?php declare(strict_types=1);

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
        $dataDirectory = __DIR__ . '/../data/';

        $this->analyse(
            [$dataDirectory . 'ClassAWithUnscopedConstant.php'], [
            [
                'Class constant FOO must declare a visibility',
                7,
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
