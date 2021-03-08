<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShop\PhpDoc;

use PhpParser\Comment\Doc;

class PhpDocAnalyzer
{
    public function containsInheritDocTag(Doc $docComment): bool
    {
        return ((strpos($docComment->getText(), '{@inheritdoc}') !== false)
            || (strpos($docComment->getText(), '{@inheritDoc}') !== false));
    }
}
