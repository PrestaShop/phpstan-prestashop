<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShopTests\PhpDoc;

use PhpParser\Comment\Doc;
use PHPStanForPrestaShop\PhpDoc\PhpDocAnalyzer;
use PHPUnit\Framework\TestCase;

class PhpDocAnalyzerTest extends TestCase
{
    public function testEmptyComment()
    {
        $phpDocAnalyzer = new PhpDocAnalyzer();

        $comment = new Doc('', 3, 10, 4, 6, 6, 7);

        $this->assertFalse($phpDocAnalyzer->containsInheritDocTag($comment));
    }

    public function testCommentWithoutInheritDoc()
    {
        $phpDocAnalyzer = new PhpDocAnalyzer();

        $doc = '/**
     * @param int $a
     */';
        $comment = new Doc($doc, 3, 10, 4, 6, 6, 7);

        $this->assertFalse($phpDocAnalyzer->containsInheritDocTag($comment));
    }

    public function testCommentWithInheritdocLowcaseD()
    {
        $phpDocAnalyzer = new PhpDocAnalyzer();

        $doc = '/**
     * {@inheritdoc}
     */';
        $comment = new Doc($doc, 3, 10, 4, 6, 6, 7);

        $this->assertTrue($phpDocAnalyzer->containsInheritDocTag($comment));
    }

    public function testCommentWithInheritdocUppercaseD()
    {
        $phpDocAnalyzer = new PhpDocAnalyzer();

        $doc = '/**
     * {@inheritdoc}
     */';
        $comment = new Doc($doc, 3, 10, 4, 6, 6, 7);

        $this->assertTrue($phpDocAnalyzer->containsInheritDocTag($comment));
    }
}
