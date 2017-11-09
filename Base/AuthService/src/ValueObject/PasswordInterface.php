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

namespace Base\AuthService\ValueObject;

/**
 * Password Value Object Interface
 *
 * @package Base\AuthService\ValueObject
 */
interface PasswordInterface
{
    /**
     * Create a Password Hash
     *
     * @param string $password
     *
     * @return self
     */
    public static function createPasswordHash(string $password): PasswordInterface;

    /**
     * Set the value of passwordHash
     *
     * @param  string $passwordHash
     *
     * @return $this
     */
    public function setPasswordHash(string $passwordHash);

    /**
     * Return the value of passwordHash
     *
     * @return string
     */
    public function getPasswordHash(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
