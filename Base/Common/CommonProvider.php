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

namespace Base\Common;

/**
 * Common Provider
 *
 * @package Base\Common
 */
class CommonProvider
{
    /**
     * Get Config
     *
     * @return array Config array
     */
    public static function getConfig()
    {
        return [
          'definitions' => [
            /**
             * Entities and Value Objects
             */
            \Base\Common\ValueObject\TenantIdInterface::class => \Base\Common\ValueObject\TenantId::class

          ],
          'params' => [
            /**
             * Factories
             */
            \Base\Common\Factory\TenantIdFactory::class => [
              'className' => \Base\Common\ValueObject\TenantId::class
            ]

          ]
        ];
    }
}
