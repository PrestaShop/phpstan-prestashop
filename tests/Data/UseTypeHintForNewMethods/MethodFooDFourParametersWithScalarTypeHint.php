<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

class MethodFooDFourParametersWithScalarTypeHint
{
    public function foo(string $a, int $b, ?array $c, bool $e)
    {
        return sprintf('hello world %s', $b);
    }
}
