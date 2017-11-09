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
use Base\AppService\Entity\AppUsageInterface;

/**
 * App Usage Factory
 *
 * @package Base\AppService\Factory
 */
class AppUsageFactory implements AppUsageFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @param FactoryInterface $factory
     * @param FactoryInterface $variantFactory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return AppUsageInterface
     */
    public function create(): AppUsageInterface
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
