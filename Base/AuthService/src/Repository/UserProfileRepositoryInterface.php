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

namespace Base\AuthService\Repository;

use Base\AuthService\Entity\UserProfileInterface;

/**
 * User Profile Repository Interface
 *
 * @package Base\AuthService\Repository
 */
interface UserProfileRepositoryInterface
{
    /**
     * Find User Profile of by a User Id of a Tenant
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return UserProfileInterface|null
     */
    public function find(string $tenantId, int $userId): ?UserProfileInterface;

    /**
     * Add a User Profile
     *
     * @param UserProfileInterface $item
     *
     * @return UserProfileInterface|null
     */
    public function insert(UserProfileInterface $item): ?UserProfileInterface;

    /**
     * Update a User Profile
     *
     * @param UserProfileInterface $item
     *
     * @return UserProfileInterface|null
     */
    public function update(UserProfileInterface $item): ?UserProfileInterface;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserProfileInterface|null
     */
    public function convertToEntity($data): ?UserProfileInterface;
}
