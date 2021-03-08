<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypeHintForNewMethods;

class MethodWithInheritPhpDoc
{
    /**
     * {@inheritdoc}
     */
    public function foo()
    {
        return;
    }

    /**
     * Alternative with capital D
     * {@inheritDoc}
     */
    public function bar()
    {
        return;
    }
}
