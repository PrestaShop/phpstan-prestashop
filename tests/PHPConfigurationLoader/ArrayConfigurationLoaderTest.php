<?php

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
}
