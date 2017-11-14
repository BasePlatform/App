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

use Base\AuthService\Entity\UserIdentityInterface;

/**
 * User Identity Repository Interface
 *
 * @package Base\AuthService\Repository
 */
interface UserIdentityRepositoryInterface
{
    /**
     * Find User Identity of by a User Id of a Tenant
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return UserIdentityInterface|null
     */
    public function find(string $tenantId, int $userId): ?UserIdentityInterface;

    /**
     * Insert a User Identity
     *
     * @param UserIdentityInterface $item
     *
     * @return UserIdentityInterface|null
     */
    public function insert(UserIdentityInterface $item): ?UserIdentityInterface;

    /**
     * Update a User Identity
     *
     * @param UserIdentityInterface $item
     *
     * @return UserIdentityInterface|null
     */
    public function update(UserIdentityInterface $item): ?UserIdentityInterface;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserIdentityInterface|null
     */
    public function convertToEntity($data): ?UserIdentityInterface;
}
