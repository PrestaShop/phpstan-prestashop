<?php

declare(strict_types=1);

namespace PHPStanForPrestaShop\PHPConfigurationLoader;

class PHPConfigurationFileLoader implements ConfigurationLoaderInterface
{
    /** @var string */
    private $filepath;

    /** @var array */
    private $configurationCache;

    /**
     * @param $filepath
     */
    public function __construct(string $filepath)
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException(
                sprintf('Given filepath must be valid, %s does not exist', $filepath)
            );
        }

        $this->filepath = $filepath;
    }

    public function load(): array
    {
        if ($this->configurationCache === null) {
            $this->configurationCache = require_once $this->filepath;
        }

        return $this->configurationCache;
    }
}
