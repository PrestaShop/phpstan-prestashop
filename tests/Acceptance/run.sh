#!/bin/bash

echo "Running PHPStan 0.12.81 against dummy app..."

phpstan_output=$(php phpstan_0.12.81.phar analyse DummyApp/ --error-format=json)

echo "Validate PHPStan report..."

php ValidateResult/validatePHPStanOutput.php "$phpstan_output"

echo "No issues reported!"

exit 0;
