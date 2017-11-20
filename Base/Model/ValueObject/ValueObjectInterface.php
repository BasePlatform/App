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

namespace Base\Model\ValueObject;

/**
 * Value Object Interface
 *
 * @package Base\Model\ValueObject
 */
interface ValueObjectInterface
{
    /**
     * Value Object Equals Comparision
     *
     * @param ValueObjectInterface $other
     *
     * @return boolean
     */
    public function equals(ValueObjectInterface $other): bool;
}
