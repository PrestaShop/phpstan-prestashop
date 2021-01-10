# PrestaShop PHPStan extension

![PHP tests](https://github.com/prestashop/phpstan-prestashop/workflows/PHP%20tests/badge.svg)

PHPStan extension for PrestaShop: provides custom rules used in PrestaShop project.

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

## Use in a project

To use this extension, first require it in [Composer](https://getcomposer.org/):

```bash
composer require --dev prestashop/phpstan-prestashop
```

Then you need to include extension.neon in your project's PHPStan config:

```neon
includes:
    - vendor/prestashop/phpstan-prestashop/extension.neon
```

You need to provide a service that is an instance of `PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface` named `@strictTypesForNewClassesRuleConfigurationFileLoader`. It is used by rule `UseStrictTypesForNewClassesRule`.

There is two available implementations: `PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader` and `PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader`.

Example with PHPConfigurationFileLoader:

```neon
services:
	strictTypesForNewClassesRuleConfigurationFileLoader:
		class: PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader
		arguments:
			- .github/workflows/phpstan/list.php
```
