<?php

declare(strict_types=1);

namespace PHPStanForPrestaShop\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassConst;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class ClassConstantsMustHaveVisibilityRule implements Rule
{
    public function getNodeType(): string
    {
        return ClassConst::class;
    }

    /**
     * @param ClassConst $node
     * @param Scope $scope
     *
     * @return array
     *
     * @throws \PHPStan\ShouldNotHappenException
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $constantDeclaresVisibility = (($node->flags & Node\Stmt\Class_::VISIBILITY_MODIFIER_MASK) !== 0);

        if (!$constantDeclaresVisibility) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'Class constant %s must declare a visibility',
                        $node->consts[0]->name
                    )
                )->build(),
            ];
        }

        return [];
    }
}
