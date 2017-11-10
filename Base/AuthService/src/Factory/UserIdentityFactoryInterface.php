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
use Base\TenantService\ValueObject\PasswordInterface;

/**
 * User Identity Factory Interface
 *
 * @package Base\AuthService\Factory
 */
interface UserIdentityFactoryInterface extends FactoryInterface
{
    /**
     * Create an instance of PasswordInterface
     *
     * @return PasswordInterface
     */
    public function createPassword(): PasswordInterface;

    /**
     * Return the class name of Password Factory
     *
     * @return string
     */
    public function getPasswordClassName(): string;
}
