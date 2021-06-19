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
use PHPStan\Type\FileTypeMapper;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\MixedType;
use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;
use PHPStanForPrestaShop\PhpDoc\PhpDocAnalyzer;

/**
 * @implements Rule<Node\Stmt\ClassMethod>
 */
class UseTypeHintForNewMethodsRule implements Rule
{
    /** @var array */
    private $excludedClassMethodsList;

    /** @var PhpDocAnalyzer */
    private $phpDocAnalyzer;

    /** @var FileTypeMapper */
    private $fileTypeMapper;

    /**
     * @param ConfigurationLoaderInterface $configurationFileLoader
     * @param PhpDocAnalyzer $phpDocAnalyzer
     */
    public function __construct(
        ConfigurationLoaderInterface $configurationFileLoader,
        PhpDocAnalyzer $phpDocAnalyzer,
        FileTypeMapper $fileTypeMapper)
    {
        $this->excludedClassMethodsList = $configurationFileLoader->load();
        $this->phpDocAnalyzer = $phpDocAnalyzer;
        $this->fileTypeMapper = $fileTypeMapper;
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
        if ($node->isMagic()) {
            return [];
        }
        if ($scope->isInTrait()) {
            return [];
        }

        $docComment = $node->getDocComment();
        if (null !== $docComment && $this->phpDocAnalyzer->containsInheritDocTag($docComment)) {
            return [];
        }

        // Check if class method is part of the exclusion list. Yes => no violations
        $className = $scope->getClassReflection()->getName();
        $fullMethodName = $className . '::' . $node->name;
        if (in_array($fullMethodName, $this->excludedClassMethodsList)) {
            return [];
        }

        $notTypedParameters = $this->findNotTypedParameters($node, $scope);
        // If class method has no untyped parameters => no violations
        if (empty($notTypedParameters)) {
            return [];
        }

        $parentClassNames = $scope->getClassReflection()->getParentClassesNames();
        if (empty($parentClassNames)) {
            // Class method does not use typed hints and has no parents => rule violation
            return [
                RuleErrorBuilder::message($this->buildErrorMessage($node->name->name, $notTypedParameters))
                    ->build(),
            ];
        }

        foreach ($parentClassNames as $parentClassName) {
            $fullParentMethodName = $parentClassName . '::' . $node->name;
            if (in_array($fullParentMethodName, $this->excludedClassMethodsList)) {
                // If class has parents who also have this class method
                // If they are part of the exclusion list => no violations
                return [];
            }
        }

        // If we are here, then there are untyped parameters and they are not excluded => rule violation
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
    private function findNotTypedParameters(ClassMethod $node, Scope $scope): array
    {
        $notTypedParameters = [];

        foreach ($node->getParams() as $parameter) {
            $parameterName = $parameter->var->name;
            if (($parameter->type === null) && !$this->parameterHasTypeMixedInPhpDoc($parameterName, $node, $scope)) {
                $notTypedParameters[] = $parameterName;
            }
        }
        return $notTypedParameters;
    }

    /**
     * @param string $parameterName
     * @param ClassMethod $node
     * @param Scope $scope
     *
     * @return bool
     */
    private function parameterHasTypeMixedInPhpDoc(string $parameterName, ClassMethod $node, Scope $scope): bool
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return false;
        }

        $functionName = $node->name->name;
        $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc(
            $scope->getFile(),
            $scope->isInClass() ? $scope->getClassReflection()->getName() : null,
            $scope->isInTrait() ? $scope->getTraitReflection()->getName() : null,
            $functionName,
            $docComment->getText()
        );

        foreach ($resolvedPhpDoc->getParamTags() as $currentParameterName => $phpDocParamTag) {
            if (($parameterName === $currentParameterName) && ($phpDocParamTag->getType() instanceof MixedType)) {
                return true;
            }
        }

        return false;
    }
}
