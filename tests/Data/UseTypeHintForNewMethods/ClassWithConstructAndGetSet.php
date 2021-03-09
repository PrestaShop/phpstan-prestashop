<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

class ClassWithConstructAndGetSet
{
    private $a;

    // no type hint, but that's OK
    public function __construct($a)
    {
        $this->a = $a;
    }

    // no type hint, but that's OK
    public function __get($name)
    {

    }

    // no type hint, but that's OK
    public function __set($name, $value)
    {

    }
}
