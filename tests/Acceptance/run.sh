#!/bin/bash

echo "Running PHPStan 0.12.81 against dummy app..."

phpstan_output=$(php tests/Acceptance/phpstan_0.12.81.phar analyse tests/Acceptance/DummyApp/ --error-format=json -l 5 -c tests/Acceptance/phpstan.neon)

echo "Validate PHPStan report..."

php tests/Acceptance/ValidateResult/validatePHPStanOutput.php "$phpstan_output"

echo "No issues reported!"

exit 0;
