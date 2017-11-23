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

namespace Base\UnitOfWork;

use Base\Db\DataMapper\DataMapperInterface;
use Base\Model\Entity\EntityInterface;

/**
 * Unit Of Work
 *
 * @package Base\UnitOfWork
 */
class UnitOfWork implements UnitOfWorkInterface
{
    /**
     * State New
     */
    const STATE_NEW = 'NEW';

    /**
     * State Clean
     */
    const STATE_CLEAN   = 'CLEAN';

    /**
     * State Dirty
     */
    const STATE_DIRTY   = 'DIRTY';

    /**
     * State Deleted
     */
    const STATE_DELETED = 'DELETED';

    /**
     * Data Mappers
     *
     * @var array
     */
    protected $dataMappers = [];

    /**
     * @var SplObjectStorage[]
     */
    protected $storage;

    /**
     * Set dataMappers property and check for the valid Data Mapper Type by checking if the class implement the DataMapperInterface
     *
     * @param array $dataMappers
     */
    public function __construct(array $dataMappers)
    {
        if (!empty($dataMappers)) {
            foreach ($dataMappers as $dataMapper) {
                if (!($dataMapper instanceof DataMapperInterface)) {
                    throw new \InvalidArgumentException(sprintf('Unsupported Data Mapper Type `%s`', get_class($dataMapper)));
                }
            }
            $this->dataMappers = $dataMappers;
            $this->storage = [];
        } else {
            throw new \InvalidArgumentException('Unit Of Work Requires Data Mapper(s) To Work Properly');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function registerNew(EntityInterface $entity)
    {
        $this->registerEntity($entity, self::STATE_NEW);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerClean(EntityInterface $entity)
    {
        $this->registerEntity($entity, self::STATE_CLEAN);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerDirty(EntityInterface $entity)
    {
        $this->registerEntity($entity, self::STATE_DIRTY);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function registerDeleted(EntityInterface $entity)
    {
        $this->registerEntity($entity, self::STATE_DELETED);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    private function registerEntity(EntityInterface $entity, string $state = self::STATE_CLEAN)
    {
        $entityClass = get_class($entity);
        if (!isset($this->storage[$entityClass])) {
            $this->storage[$entityClass] = new SplObjectStorage();
            $this->storage[$entityClass]->attach($entity, $state);
        } else {
            // Ensure the unique of entity
            if ($this->storage[$entityClass]->contains($entity)) {
                $this->storage[$entityClass]->detach($entity);
            }
            $this->storage[$entityClass]->attach($entity, $state);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        // We process based on entiy class group
        foreach ($this->storage as $class => $entityStorage) {
            $dataMapper = $this->getDataMapperByEnityClass($class);
            try {
                $dataMapper->getDbAdapter()->beginTransaction();
                foreach ($entityStorage as $entity) {
                    switch ($entityStorage[$entity]) {
                        case self::STATE_NEW:
                            $dataMapper->insert($entity);
                            break;
                        case self::STATE_DIRTY:
                            $dataMapper->update($entity);
                            break;
                        case self::STATE_DELETED:
                            $dataMapper->delete($entity);
                            break;
                    }
                }
                return $dataMapper->getDbAdapter()->commit();
            } catch (\Exception $e) {
                return $dataMapper->getDbAdapter()->rollBack();
            }
        }
        $this->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->storage = [];
    }

    /**
     * Get Data Mapper Based on the interface of Entity
     *
     * @param  string $entityClass
     * @return mixed
     */
    final private function getDataMapperByEnityClass(string $entityClass)
    {
        $entityInterfaces = class_implements($entity);
        if ($entityInterfaces) {
            $continue = true;
            $dataMapperPosition = null;
            for ($i = 0; $i < count($dataMappers) && $continue; $i++) {
                if (in_array($dataMappers[$i]->getEntityInterface(), $entityInterfaces)) {
                    $continue = false;
                    $dataMapperPosition = $i;
                }
            }
            if ($dataMapperPosition) {
                return $dataMappers[$dataMapperPosition];
            }
            throw new \InvalidArgumentException(sprintf('No Data Mapper Found For Entity `%s`', get_class($entity)));
        } else {
            throw new \InvalidArgumentException(sprintf('No Entity Interface Found For Data Mapper To Work Properly `%s`', get_class($entity)));
        }
    }
}
