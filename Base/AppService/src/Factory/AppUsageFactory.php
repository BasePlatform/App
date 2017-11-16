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

namespace Base\AppService\Factory;

use Base\Factory\FactoryInterface;

/**
 * App Usage Factory
 *
 * @package Base\AppService\Factory
 */
class AppUsageFactory implements AppUsageFactoryInterface
{
    use \Base\Factory\FactoryTrait;

    /**
     * @param string $className
     */
    public function __construct(string $className)
    {
        $this->className = $className;
    }
}
