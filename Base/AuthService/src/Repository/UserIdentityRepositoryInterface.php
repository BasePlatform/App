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

use Base\AuthServivce\Entity\UserIdentityInterface;

/**
 * User Identity Repository Interface
 *
 * @package Base\AuthServivce\Repository
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
     * Add a User Identity
     *
     * @param UserIdentityInterface $item
     *
     * @return integer|null The inserted User Identity Id
     */
    public function add(UserIdentityInterface $item): ?integer;

    /**
     * Update a User Identity
     *
     * @param UserIdentityInterface $item
     *
     * @return boolean
     */
    public function update(UserIdentityInterface $item): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserIdentityInterface|null
     */
    public function convertToEntity($data): ?UserIdentityInterface;
}
