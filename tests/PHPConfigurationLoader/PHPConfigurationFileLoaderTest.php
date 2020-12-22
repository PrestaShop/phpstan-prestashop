<?php

declare(strict_types=1);

namespace PHPStanForPrestaShopTests\PHPConfigurationLoader;

use PHPStanForPrestaShop\PHPConfigurationLoader\ConfigurationLoaderInterface;
use PHPStanForPrestaShop\PHPConfigurationLoader\PHPConfigurationFileLoader;
use PHPUnit\Framework\TestCase;

class PHPConfigurationFileLoaderTest extends TestCase
{
    public function testImplementsInterface()
    {
        $loader = new PHPConfigurationFileLoader(__DIR__ . '/../data/dummyConfigFile.php');
        $this->assertInstanceOf(ConfigurationLoaderInterface::class, $loader);
    }

    public function testLoadedConfiguration()
    {
        $loader = new PHPConfigurationFileLoader(__DIR__ . '/../data/dummyConfigFile.php');
        $this->assertEquals(['abc'], $loader->load());
    }
}
