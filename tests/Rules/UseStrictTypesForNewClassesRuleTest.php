<?php declare(strict_types = 1);

namespace PHPStanForPrestaShopTests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use PHPStanForPrestaShop\Rules\UseStrictTypesForNewClassesRule;

class UseStrictTypesForNewClassesRuleTest extends RuleTestCase
{

	protected function getRule(): Rule
	{
		return new UseStrictTypesForNewClassesRule();
	}

	public function testRule(): void
	{
		$dataDirectory = __DIR__ . '/../data/';

		$this->analyse(
			[$dataDirectory.'NoDeclareStrictTypeClassA.php'], [
			[
				'Class should declare strict type.',
				3,
			],
		]);
		$this->analyse(
			[$dataDirectory.'NoDeclareStrictTypeClassB.php'], [
			[
				'Class should declare strict type.',
				3,
			],
		]);
		$this->analyse(
			[$dataDirectory.'DeclareStrictTypeClassC.php'], []
        );
	}
}
