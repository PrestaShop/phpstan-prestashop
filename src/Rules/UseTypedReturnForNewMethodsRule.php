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
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;

/**
 * @implements Rule<Node\Stmt\ClassMethod>
 */
class UseTypedReturnForNewMethodsRule implements Rule
{
    /** @var array */
    private $excludedClassMethodsList;

    /**
     * @param ConfigurationLoaderInterface $configurationFileLoader
     */
    public function __construct(ConfigurationLoaderInterface $configurationFileLoader)
    {
        $this->excludedClassMethodsList = $configurationFileLoader->load();
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeType(): string
    {
        return ClassMethod::class;
    }

    /**
     * @param ClassMethod $node
     * @param Scope $scope
     *
     * @return array
     * @throws \PHPStan\ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $className = $scope->getClassReflection()->getName();
        $fullMethodName = $className . '::' . $node->name;
        if (in_array($fullMethodName, $this->excludedClassMethodsList)) {
            return [];
        }

        if (!$node->getReturnType()) {
            return [
                RuleErrorBuilder::message(sprintf('Function %s should declare return type.', $node->name))
                    ->build(),
            ];
        }

        return [];
    }
}
