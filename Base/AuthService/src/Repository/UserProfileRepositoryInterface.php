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

namespace Base\AuthServivce\Repository;

use Base\AuthServivce\Entity\UserProfileInterface;

/**
 * User Profile Repository Interface
 *
 * @package Base\AuthServivce\Repository
 */
interface UserProfileRepositoryInterface
{
    /**
     * Get User Profile of by a User Id of a Tenant
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return UserProfileInterface|null
     */
    public function get(string $tenantId, int $userId): ?UserProfileInterface;

    /**
     * Add a User Profile
     *
     * @param UserProfileInterface $item
     *
     * @return integer|null The inserted User Profile Id
     */
    public function add(UserProfileInterface $item): ?integer;

    /**
     * Update a User Profile
     *
     * @param UserProfileInterface $item
     *
     * @return boolean
     */
    public function update(UserProfileInterface $item): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserProfileInterface|null
     */
    public function convertToEntity($data): ?UserProfileInterface;
}
