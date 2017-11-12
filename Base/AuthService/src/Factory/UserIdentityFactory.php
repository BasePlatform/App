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
use Base\AuthService\Entity\UserIdentityInterface;
use Base\AuthService\ValueObject\PasswordInterface;

/**
 * User Identity Factory
 *
 * @package Base\AuthService\Factory
 */
class UserIdentityFactory implements UserIdentityFactoryInterface
{
    use \Base\Factory\FactoryTrait;

    /**
     * @var string
     */
    private $passwordClassName;

    /**
     * @param string $className
     * @param string $passwordClassName
     */
    public function __construct(string $className, string $passwordClassName)
    {
        $this->className = $className;
        $this->passwordClassName = $passwordClassName;
    }

    /**
     * {@inheritdoc}
     */
    public function createPassword(): PasswordInterface
    {
        return new $this->passwordClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordClassName(): string
    {
        return new $this->passwordClassName;
    }
}
