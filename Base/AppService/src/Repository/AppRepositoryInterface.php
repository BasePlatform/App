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

namespace Base\AppService\Repository;

use Base\AppService\Entity\AppInterface;

/**
 * App Repository Interface
 *
 * @package Base\AppService\Repository
 */
interface AppRepositoryInterface
{
    /**
     * Find App by App Id
     *
     * @param string $apId
     *
     * @return AppInterface|null
     */
    public function find(string $appId): ?AppInterface;

    /**
     * Insert an App
     *
     * @param AppInterface $item
     *
     * @return AppInterface|null
     */
    public function insert(AppInterface $item): ?AppInterface;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return AppInterface|null
     */
    public function convertToEntity($data): ?AppInterface;
}
