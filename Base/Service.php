<?php
/*
 * This file is part of the BasePlatform project.
 *
 * @link https://github.com/BasePlatform
 * @license https://github.com/BasePlatform/Base/blob/master/LICENSE.txt
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Base;

use Base\Config\ConfigInterface;

/**
 * Base Service Helper Class acts as a Registry
 *
 * @package Base
 */
class Service
{
    /**
     * @var \Base\Config\ConfigInterface
     */
    public static $config;
}
