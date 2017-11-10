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
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var FactoryInterface
     */
    private $passwordFactory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, FactoryInterface $passwordFactory)
    {
        $this->factory = $factory;
        $this->passwordFactory = $passwordFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): UserIdentityInterface
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function createPassword(): PasswordInterface
    {
        return $this->passwordFactory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return $this->factory->getClassName();
    }

    /**
     * {@inheritdoc}
     */
    public function getPasswordClassName(): string
    {
        return $this->passwordFactory->getClassName();
    }
}
