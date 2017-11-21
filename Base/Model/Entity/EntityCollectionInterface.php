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

namespace Base\Model\Entity;

use Countable;
use ArrayAccess;
use IteratorAggregate;

/**
 * Entity Interface
 *
 * @package Base\Model\Entity
 */
interface EntityCollectionInterface extends Countable, ArrayAccess, IteratorAggregate
{
    /**
     * Add Entity to Collection
     *
     * @param EntityInterface $item
     *
     * @return void
     */
    public function add(EntityInterface $item): void;

    /**
     * Remove Entity from Collection
     *
     * @param EntityInterface $item
     *
     * @return void
     */
    public function remove(EntityInterface $item): void;

    /**
     * Get Entity from Collection
     *
     * @param mixed $key
     *
     * @return EntityInterface|null
     */
    public function get($key): ?EntityInterface;

    /**
     * Check Entity exists in Collection
     *
     * @param mixed $key
     *
     * @return boolean
     */
    public function exists($key): bool;

    /**
     * Reset Collection
     *
     * @return void
     */
    public function clear(): void;

    /**
     * To Array
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Count
     *
     * @return int
     */
    public function count(): int;

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value);

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key);

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key);

    /**
     * {@inheritdoc}
     */
    public function offsetExists($key);

    /**
     * {@inheritdoc}
     */
    public function getIterator();
}
