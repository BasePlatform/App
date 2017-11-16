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

namespace Base\Factory;

/**
 * Factory Trait for creating resource based on FQCN
 *
 * @package Base\Factory
 */
trait FactoryTrait
{
    /**
     * @var string
     */
    private $className;

    /**
     * Create an object from the class
     *
     * @return object
     */
    public function create()
    {
        return new $this->className();
    }

    /**
     * {@inheritdoc}
     */
    public function getClassName(): string
    {
        return $this->className;
    }
}
