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

namespace Base\Model\ValueObject;

/**
 * Value Object Trait with type checking function
 *
 * @package Base\Model\ValueObject
 */
trait ValueObjectTrait
{
    /**
     * Return whether other class is the same as this object.
     *
     * @param ValueObjectInterface $other
     *
     * @return boolean
     */
    final private function isSameType(ValueObjectInterface $other)
    {
        return get_called_class() === get_class($other);
    }
}
