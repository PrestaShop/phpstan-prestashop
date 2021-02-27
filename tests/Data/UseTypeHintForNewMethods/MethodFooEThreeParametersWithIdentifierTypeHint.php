<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

use DateTime;

class MethodFooEThreeParametersWithIdentifierTypeHint
{
    public function foo(MethodFooAWithoutTypeHint $a, DateTime $b, ?DateTime $c)
    {
        return sprintf('hello world %s', $b->format('Y-m-d'));
    }
}
