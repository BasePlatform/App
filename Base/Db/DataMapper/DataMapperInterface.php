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

namespace Base\Db\DataMapper;

/**
 * Data Mapper Interface
 *
 * @package Base\Db\DataMapper
 */
interface DataMapperInterface
{
    /**
     * Get Entity Interface
     *
     * This helps for getting the right mapper based on the
     * entity class for working with multiple entity types in UnitOfWork
     *
     * @return string
     */
    public function getEntityInterface(): string;
}
