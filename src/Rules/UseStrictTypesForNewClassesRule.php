<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShop\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStanForPrestaShop\PHPConfigurationFileLoader;
use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;

/**
 * @implements Rule<Node\Stmt\Class_>
 */
class UseStrictTypesForNewClassesRule implements Rule
{
    /** @var array */
    private $excludedClassList;

    /**
     * @param ConfigurationLoaderInterface $configurationFileLoader
     */
    public function __construct(ConfigurationLoaderInterface $configurationFileLoader)
    {
        $this->excludedClassList = $configurationFileLoader->load();
    }

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
        $namespace = $scope->getNamespace();
        $fullyQualifiedName = ($namespace ? $namespace . '\\' : '') . $node->name;
        if (in_array($fullyQualifiedName, $this->excludedClassList)) {
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
}
