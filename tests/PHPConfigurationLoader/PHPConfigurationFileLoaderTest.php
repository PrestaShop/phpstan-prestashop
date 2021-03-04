<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShopTests\PHPConfigurationLoader;

use InvalidArgumentException;
use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;
use PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader;
use PHPUnit\Framework\TestCase;

class PHPConfigurationFileLoaderTest extends TestCase
{
    public function testImplementsInterface()
    {
        $loader = new PHPConfigurationFileLoader(__DIR__ . '/../Data/dummyConfigurationFile.php');
        $this->assertInstanceOf(ConfigurationLoaderInterface::class, $loader);
    }

    public function testLoadedConfiguration()
    {
        $loader = new PHPConfigurationFileLoader(__DIR__ . '/../Data/dummyConfigurationFile.php');
        $this->assertEquals(['abc'], $loader->load());
    }

    public function testBadFilepath()
    {
        $this->expectException(InvalidArgumentException::class);

        $loader = new PHPConfigurationFileLoader(__DIR__ . '/../Data/a.php');
    }

    public function testLoadTwiceTheSameFile()
    {
        $loader1 = new PHPConfigurationFileLoader(__DIR__ . '/../Data/dummyConfigurationFile.php');

        $loader2 = new PHPConfigurationFileLoader(__DIR__ . '/../Data/dummyConfigurationFile.php');

        $this->assertEquals(['abc'], $loader1->load());
        $this->assertEquals(['abc'], $loader2->load());
    }
}
