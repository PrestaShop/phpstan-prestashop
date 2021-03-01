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
class UseTypeHintForNewMethodsRule implements Rule
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

        $notTypedParameters = $this->findNotTypedParameters($node);

        if (empty($notTypedParameters)) {
            return [];
        }

        $parentClassNames = $scope->getClassReflection()->getParentClassesNames();
        if (empty($parentClassNames)) {
            // class method does not use typed hints and has no parents, it's a rule violation
            return [
                RuleErrorBuilder::message($this->buildErrorMessage($node->name->name, $notTypedParameters))
                    ->build(),
            ];
        }

        foreach ($parentClassNames as $parentClassName) {
            $fullParentMethodName = $parentClassName . '::' . $node->name;
            if (in_array($fullParentMethodName, $this->excludedClassMethodsList)) {
                return [];
            }
        }

        return [
            RuleErrorBuilder::message($this->buildErrorMessage($node->name->name, $notTypedParameters))
                ->build(),
        ];
    }

    /**
     * @param string $functionName
     * @param array $notTypedParameters
     *
     * @return string
     */
    private function buildErrorMessage(string $functionName, array $notTypedParameters)
    {
        return sprintf('Every parameter of function %s should be type hinted ' .
            '(untyped parameters: %s).',
            $functionName,
            implode(', ', $notTypedParameters)
        );
    }

    /**
     * @param ClassMethod $node
     *
     * @return array
     */
    private function findNotTypedParameters(ClassMethod $node): array
    {
        $notTypedParameters = [];

        foreach ($node->getParams() as $parameter) {
            if ($parameter->type === null) {
                $notTypedParameters[] = $parameter->var->name;
            }
        }
        return $notTypedParameters;
    }
}