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
 * Password Value Object
 *
 * @package Base\AuthService\ValueObject
 */
class Password implements PasswordInterface
{
    /**
     * @var string
     */
    protected $passwordHash;

    /**
     * @param string $passwordHash
     */
    public function __construct(string $passwordHash = null)
    {
        if (!empty($passwordHash)) {
            $this->passwordHash = $passwordHash;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function createPasswordHash(string $password): PasswordInterface
    {
        return new self(password);
    }

    /**
     * {@inheritdoc}
     */
    public function setPasswordHash(string $passwordHash)
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->passwordHash;
    }
}
