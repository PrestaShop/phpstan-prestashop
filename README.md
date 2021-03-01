# PrestaShop PHPStan extension

![PHP tests](https://github.com/prestashop/phpstan-prestashop/workflows/PHP%20tests/badge.svg)
![Static Analysis](https://github.com/PrestaShop/phpstan-prestashop/workflows/Static%20Analysis/badge.svg)
[![GitHub release](https://img.shields.io/github/v/release/prestashop/phpstan-prestashop)](https://github.com/PrestaShop/phpstan-prestashop)
[![GitHub license](https://img.shields.io/github/license/PrestaShop/phpstan-prestashop)](https://github.com/PrestaShop/phpstan-prestashop/LICENSE.md)

* [PHPStan](https://phpstan.org/)
* [PrestaShop](https://github.com/prestashop/prestashop)

## Content

This PHPStan extension adds custom rules to PHPStan:

- ClassConstantsMustHaveVisibilityRule
- UseStrictTypesForNewClassesRule
- UseTypeHintForNewMethodsRule
- UseTypedReturnForNewMethodsRule

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

Rules are tested using PHPStan [RuleTestCase](https://github.com/phpstan/phpstan-src/blob/master/src/Testing/RuleTestCase.php).

Run static analysis with PHPStan:
```bash
vendor/bin/phpstan analyse src tests -l 5
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

### Required settings

#### UseStrictTypesForNewClassesRule

Rule `UseStrictTypesForNewClassesRule` requires loading of a configuration asset.

You need to provide a service that is an instance of `PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface`,
named `@strictTypesForNewClassesRuleConfigurationFileLoader`. It should load an array of classes for which
the `UseStrictTypesForNewClassesRule` should not be applied.

There is two available implementations: `PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader`
and `PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader`.

Example with `PHPConfigurationFileLoader`:

```neon
services:
    strictTypesForNewClassesRuleConfigurationFileLoader:
        class: PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader
        arguments:
            - .github/workflows/phpstan/exclude-class-list.php
```

#### UseTypedReturnForNewMethodsRule

Rule `UseTypedReturnForNewMethodsRule` requires loading of a configuration asset.

You need to provide a service that is an instance of `PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface`,
named `@returnTypesForNewMethodsRuleConfigurationFileLoader`. It should load an array of class methods for which
the `UseTypedReturnForNewMethodsRule` should not be applied.

There is two available implementations: `PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader`
and `PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader`.

Example with `PHPConfigurationFileLoader`:

```neon
services:
    returnTypesForNewMethodsRuleConfigurationFileLoader:
        class: PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader
        arguments:
            - .github/workflows/phpstan/exclude-return-functions-list.php
```

#### UseTypeHintForNewMethodsRule

Similarly to `UseTypedReturnForNewMethodsRule`, rule `UseTypeHintForNewMethodsRule` requires loading of an instance of `PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface`,
named `@typeHintsForNewMethodsRuleConfigurationFileLoader`. It should load an array of class methods for which
the `UseTypeHintForNewMethodsRule` should not be applied.

There is two available implementations: `PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader`
and `PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader`.

Example with `PHPConfigurationFileLoader`:

```neon
services:
    typeHintsForNewMethodsRuleConfigurationFileLoader:
        class: PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader
        arguments:
            - .github/workflows/phpstan/exclude-typehint-functions-list.php
```
