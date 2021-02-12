<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShop\PHPConfigurationLoader;

class ArrayConfigurationLoader implements ConfigurationLoaderInterface
{
    /** @var array */
    private $configurationCache;

    /**
     * @param array $configuration
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
