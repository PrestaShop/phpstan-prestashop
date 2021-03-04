<?php
/*
 * Copyright (c) Since 2007 PrestaShop.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PHPStanForPrestaShop\PHPConfigurationLoader;

class PHPConfigurationFileLoader implements ConfigurationLoaderInterface
{
    /** @var string */
    private $filepath;

    /** @var array */
    private $configurationCache;

    /**
     * @param string $filepath
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
            $this->configurationCache = require $this->filepath;
        }

        return $this->configurationCache;
    }
}
