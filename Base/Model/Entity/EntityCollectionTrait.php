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

/**
 * Entity Collection Trait
 *
 * @package Base\Model\Entity
 */
class EntityCollectionTrait
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     *
     * Default value is the EntityInterface class
     *
     * For more strictly entity interface, set this property
     * to the desired entity interface in __construct() function
     *
     * @var string
     */
    protected $entityInterface = \Base\Model\Entity\EntityInterface::class;

    /**
     * {@inheritdoc}
     */
    public function add(EntityInterface $item): void
    {
        $this->offsetSet($item);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EntityInterface $item): void
    {
        $this->offsetUnset($item);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key): ?EntityInterface
    {
        return $this->offsetGet($key);
    }

    /**
     * {@inheritdoc}
     */
    public function exists($key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * {@inheritdoc}
     */
    public function clear(): void
    {
        $this->items = [];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($key, $value)
    {
        if (!$value instanceof $this->entityInterface) {
            throw new InvalidArgumentException(
                "Invalid Entity Type Of Collection"
            );
        }
        if (!isset($key)) {
            $this->items[] = $value;
        } else {
            $this->items[$key] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($key)
    {
        if ($key instanceof $this->entityInterface) {
            $this->items = array_filter(
                $this->items,
                function ($v) use ($key) {
                    return $v !== $key;
                }
            );
        } else if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($key)
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($key)
    {
        return ($key instanceof $this->entityInterface)
            ? array_search($key, $this->items)
            : isset($this->items[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
