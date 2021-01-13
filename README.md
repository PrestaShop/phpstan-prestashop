# PrestaShop PHPStan extension

![PHP tests](https://github.com/matks/phpstan-prestashop/workflows/PHP%20tests/badge.svg)
![Static Analysis](https://github.com/PrestaShop/phpstan-prestashop/workflows/Static%20Analysis/badge.svg)
[![GitHub release](https://img.shields.io/github/v/release/prestashop/phpstan-prestashop)](https://github.com/PrestaShop/phpstan-prestashop)
[![GitHub license](https://img.shields.io/github/license/PrestaShop/phpstan-prestashop)](https://github.com/PrestaShop/phpstan-prestashop/LICENSE.md)

* [PHPStan](https://phpstan.org/)
* [PrestaShop](https://github.com/prestashop/prestashop)

## Installation

Install the dependencies with [Composer](https://getcomposer.org/):
```bash
composer install
```

## Tests

Install the dev dependencies with [Composer](https://getcomposer.org/):
```bash
composer install --dev
```

Run tests using PHPUnit:
```bash
vendor/bin/phpunit -c tests/phpunit.xml tests
```

## Use for a project

To use this extension, first require it in [Composer](https://getcomposer.org/):

```bash
composer require --dev prestashop/phpstan-prestashop
```

Then you need to include extension.neon in your project's PHPStan config:

```neon
includes:
    - vendor/prestashop/phpstan-prestashop/extension.neon
```

You need to provide a `@strictTypesForNewClassesRuleConfigurationFileLoader` configuration loader instance for rule `UseStrictTypesForNewClassesRule`.

You can do it like this:

```neon
services:
	strictTypesForNewClassesRuleConfigurationFileLoader:
		class: PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader
		arguments:
			- .github/workflows/phpstan/list.php
```
