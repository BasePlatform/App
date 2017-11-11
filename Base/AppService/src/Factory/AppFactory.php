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
use Base\AppService\Entity\AppUsageInterface;

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
     * @var FactoryInterface
     */
    private $appUsagefactory;

    /**
     * @param FactoryInterface $factory
     * @param FactoryInterface $appUsagefactory
     */
    public function __construct(FactoryInterface $factory, FactoryInterface $appUsagefactory)
    {
        $this->factory = $factory;
        $this->appUsagefactory = $appUsagefactory;
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
