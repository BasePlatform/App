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

/**
 * Unit Of Work Interface
 *
 * @package Base\UnitOfWork
 */
interface UnitOfWorkInterface
{
    /**
     * Register new entity
     *
     * @param  object $entity
     * @return void
     */
    public function registerNew($entity);

    /**
     * Register clean entity
     *
     * @param  object $entity
     * @return void
     */
    public function registerClean($entity);

    /**
     * Register dirty entity
     *
     * @param  object $entity
     * @return void
     */
    public function registerDirty($entity);

    /**
     * Register deleted entity
     *
     * @param  object $entity
     * @return void
     */
    public function registerDeleted($entity);

    /**
     * Commit
     *
     * @return bool
     */
    public function commit(): bool;

    /**
     * Commit
     *
     * @return bool
     */
    public function rollBack(): bool;

    /**
     * Clear
     *
     * @return void
     */
    public function clear();
}
