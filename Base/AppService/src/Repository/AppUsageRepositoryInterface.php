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

use Base\AppService\Entity\AppUsageInterface;

/**
 * App Usage Repository Interface
 *
 * @package Base\AppService\Repository
 */
interface AppUsageRepositoryInterface
{
    /**
     * Find App Usage by App Id and Tenant Id
     *
     * @param string $tenantId
     * @param string $apId
     *
     * @return AppUsageInterface|null
     */
    public function find(string $tenantId, string $appId): ?AppUsageInterface;

    /**
     * Insert an App Usage
     *
     * @param AppUsageInterface $item
     *
     * @return AppUsageInterface|null
     */
    public function insert(AppUsageInterface $item): ?AppUsageInterface;

    /**
     * Update an App Usage
     *
     * @param AppUsageInterface $item
     *
     * @return AppUsageInterface|null
     */
    public function update(AppUsageInterface $item): ?AppUsageInterface;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return AppUsageInterface|null
     */
    public function convertToEntity($data): ?AppUsageInterface;
}
