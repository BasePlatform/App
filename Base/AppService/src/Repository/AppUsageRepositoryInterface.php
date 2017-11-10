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

namespace Base\AppServivce\Repository;

use Base\AppServivce\Entity\AppUsageInterface;

/**
 * App Usage Repository Interface
 *
 * @package Base\AppServivce\Repository
 */
interface AppUsageRepositoryInterface
{
    /**
     * Get App Usage by App Id and Tenant Id
     *
     * @param string $tenantId
     * @param string $apId
     *
     * @return AppUsageInterface|null
     */
    public function get(string $tenantId, string $appId): ?AppUsageInterface;

    /**
     * Add an App Usage
     *
     * @param AppUsageInterface $item
     *
     * @return integer|null The inserted AppUsage Id
     */
    public function add(AppUsageInterface $item): ?integer;

    /**
     * Update an App Usage
     *
     * @param AppUsageInterface $item
     *
     * @return bool
     */
    public function update(AppUsageInterface $item): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return AppUsageInterface|null
     */
    public function convertToEntity($data): ?AppUsageInterface;
}
