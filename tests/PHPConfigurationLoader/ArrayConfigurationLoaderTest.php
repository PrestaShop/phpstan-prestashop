<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShopTests\PHPConfigurationLoader;


use PHPStanForPrestaShop\PHPConfigurationLoader\ArrayConfigurationLoader;
use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;
use PHPUnit\Framework\TestCase;

class ArrayConfigurationLoaderTest extends TestCase
{
    public function testImplementsInterface()
    {
        $loader = new ArrayConfigurationLoader([]);
        $this->assertInstanceOf(ConfigurationLoaderInterface::class, $loader);
    }

    public function testIdenticalLoadedConfiguration()
    {
        $a = ['a' => ['la' => ['aa'], 'ma' => 'a'], 'ka' => 'foo'];

        $loader = new ArrayConfigurationLoader($a);
        $this->assertEquals($a, $loader->load());
    }

    public function testEmptyConfiguration()
    {
        $loader = new ArrayConfigurationLoader([]);
        $this->assertEquals([], $loader->load());
    }
}
