<?php

declare(strict_types=1);

namespace PHPStanForPrestaShop\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node\Stmt\Class_>
 */
class UseStrictTypesForNewClassesRule implements Rule
{
    /** @var array */
    private $excludedClassList;

    /**
     * {@inheritdoc}
     */
    public function getNodeType(): string
    {
        return Class_::class;
    }

    /**
     * {@inheritdoc}
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $fullyQualifiedName = $scope->getNamespace() . '\\' . $node->name;
        if (in_array($fullyQualifiedName, $this->getExcludedClassList())) {
            return [];
        }

        if (!$scope->isDeclareStrictTypes()) {
            return [
                RuleErrorBuilder::message('Class should declare strict type.')
                    ->build(),
            ];
        }

        return [];
    }

    /**
     * Fetch file strict-types-baseline.php which contain files
     * which do not use declare(strict_types=1)
     * but are not fixed to preserve backward compatibility.
     *
     * @return string[]
     */
    private function getExcludedClassList()
    {
        if (null === $this->excludedClassList) {
            $this->excludedClassList = require_once __DIR__ . '/strict-types-baseline.php';
        }

        return $this->excludedClassList;
    }
}
