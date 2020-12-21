<?php

declare(strict_types=1);

namespace PHPStanForPrestaShop\PHPConfigurationLoader;

class ArrayConfigurationLoader implements ConfigurationLoaderInterface
{
    /** @var array */
    private $configurationCache;

    /**
     * @param $filepath
     */
    public function __construct(array $configuration)
    {
        $this->configurationCache = $configuration;
    }

    public function load(): array
    {
        return $this->configurationCache;
    }
}
