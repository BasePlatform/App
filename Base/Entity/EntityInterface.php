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

namespace Base\Entity;

/**
 * Entity Interface
 *
 * @package Base\Entity
 */
interface EntityInterface extends \JsonSerializable
{
    /**
     * Return the validation rule of the entity
     *
     * @return array
     */
    public function rules(): array;

    /**
     * Array Serializable - Convert Entity to Array
     *
     * @param  array  $excludedAttributes The attributes to excluded from the returned array
     * @return array
     */
    public function toArray(array $excludedAttributes = []): array;

    /**
     * By extends \JsonSerializable
     * EntityInterface must implement this function
     *
     * public function jsonSerialize();
     *
     */
}
