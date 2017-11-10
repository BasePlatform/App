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
use Base\AppService\Entity\AppInterface;

/**
 * App Factory
 *
 * @package Base\AppService\Factory
 */
class AppFactory implements AppFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): AppInterface
    {
        return $this->factory->create();
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return $this->factory->getClassName();
    }
}
