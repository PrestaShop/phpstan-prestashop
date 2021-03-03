<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

class MethodFooCOneParameterWithTypeHintAndOneWithout
{
    public function foo(string $c, $d)
    {
        return sprintf('hello world %s', $c);
    }
}
