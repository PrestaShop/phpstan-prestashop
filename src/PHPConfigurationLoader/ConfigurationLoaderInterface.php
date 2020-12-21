<?php

declare(strict_types=1);

namespace PHPStanForPrestaShop\PHPConfigurationLoader;


interface ConfigurationLoaderInterface
{
    public function load(): array;
}
