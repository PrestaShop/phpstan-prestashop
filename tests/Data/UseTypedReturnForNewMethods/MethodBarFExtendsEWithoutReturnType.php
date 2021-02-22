<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPStanForPrestaShopTests\Data\UseTypedReturnForNewMethods;

use PHPStanForPrestaShopTests\Data\UseTypedReturnForNewMethods\E;

class MethodBarFExtendsEWithoutReturnType extends E
{
    public function bar()
    {
        return 'hello world';
    }
}
