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

use Base\Model\Entity\EntityInterface;

/**
 * Unit Of Work Trait
 *
 * @package Base\UnitOfWork
 */
trait UnitOfWorkTrait
{
    /**
     * Data Mappers
     *
     * @var array
     */
    protected $dataMappers = [];

    /**
     * @var array
     */
    protected $cleanEntities = [];

    /**
     * @var array
     */
    protected $newEntities = [];

    /**
     * @var array
     */
    protected $dirtyEntities = [];

    /**
     * @var array
     */
    protected $deletedEntities = [];


    public function registerNew(EntityInterface $entity)
    {
        $this->newEntities[] = $entity;
        return $this;
    }

    public function registerClean(EntityInterface $entity)
    {
        $this->cleanEntities[] = $entity;
        return $this;
    }

    public function registerDirty(EntityInterface $entity)
    {
        $this->dirtyEntities[] = $entity;
        return $this;
    }

    public function registerDeleted(EntityInterface $entity)
    {
        $this->deletedEntities[] = $entity;
        return $this;
    }

    public function commit()
    {
        if (!empty($this->newEntities)) {
            foreach ($this->newEntities as $entity) {
                $this->getDataMapperByEnity($entity)->insert($entity);
            }
        }
        if (!empty($this->dirtyEntities)) {
            foreach ($this->dirtyEntities as $entity) {
                $this->getDataMapperByEnity($entity)->update($entity);
            }
        }
        if (!empty($this->deletedEntities)) {
            foreach ($this->deletedEntities as $entity) {
                $this->getDataMapperByEnity($entity)->update($entity);
            }
        }
        $this->clear();
    }

    public function rollback()
    {
        return;
    }

    public function clear()
    {
        $this->cleanEntities = [];
        $this->newEntities = [];
        $this->dirtyEntities = [];
        $this->deletedEntities = [];
        return $this;
    }

    protected function getDataMapperByEnity($entity)
    {
        $entityInterfaces = class_implements($entity);
        if ($entityInterfaces) {
            $continue = true;
            $dataMapperPosition = null;
            for ($i = 0; $i < count($entityInterfaces) && $continue; $i++) {
                for ($j = 0; $j < count($dataMappers) && $continue; $j++) {
                    if ($dataMappers[$j]->getEntityInterface()
                        == $entityInterfaces[0]) {
                        $continue = false;
                        $dataMapperPosition = $j;
                    }
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
