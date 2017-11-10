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

use Base\AuthServivce\Entity\UserInterface;

/**
 * User Repository Interface
 *
 * @package Base\AuthServivce\Repository
 */
interface UserRepositoryInterface
{
    /**
     * Get User by a User Id of a Tenant
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return UserInterface|null
     */
    public function get(string $tenantId, int $userId): ?UserInterface;

    /**
     * Find a User by Zone and Email
     *
     * @param string $tenantId
     * @param string $email
     * @param ZoneInterface $zone
     *
     * @return UserInterface|null
     */
    public function findOneByZoneAndEmail(string $tenantId, string $email, ZoneInterface $zone): ?UserInterface;

    /**
     * Find a User by Zone and userName
     *
     * @param string $tenantId
     * @param string $userName
     * @param ZoneInterface $zone
     *
     * @return UserInterface|null
     */
    public function findOneByZoneAndUserName(string $tenantId, string $userName, ZoneInterface $zone): ?UserInterface;

    /**
     * Add a User
     *
     * @param UserInterface $item
     *
     * @return integer|null The inserted User Id
     */
    public function add(UserInterface $item): ?integer;

    /**
     * Update a User
     *
     * @param UserInterface $item
     *
     * @return boolean
     */
    public function update(UserInterface $item): bool;

    /**
     * Soft Delete a User
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return boolean
     */
    public function softDelete(string $tenantId, int $userId): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserIdentityInterface|null
     */
    public function convertToEntity($data): ?UserIdentityInterface;
}
