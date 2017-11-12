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

namespace Base\AuthService\Factory;

use Base\Factory\FactoryInterface;
use Base\AuthService\Entity\UserProfileInterface;

/**
 * User Profile Factory
 *
 * @package Base\AuthService\Factory
 */
class UserProfileFactory implements UserProfileFactoryInterface
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
