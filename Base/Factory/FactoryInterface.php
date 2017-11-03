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
 * Factory Interface
 *
 * @package Base\Factory
 */
interface FactoryInterface
{
    /**
     * @return object
     */
    public function createNew();

    /**
     * @return string
     */
    public function getClassName();
}
