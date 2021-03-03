<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

use PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods\F;

class MethodFooHWithoutTypeHintButExtendsAnExcludedClass extends F
{
    public function foo($a, $b)
    {
        return sprintf('hello world %s', $b);
    }
}
