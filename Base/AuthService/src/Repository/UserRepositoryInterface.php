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

use Base\AuthService\Entity\UserInterface;
use Base\AuthService\ValueObject\ZoneInterface;

/**
 * User Repository Interface
 *
 * @package Base\AuthService\Repository
 */
interface UserRepositoryInterface
{
    /**
     * Find a User by a User Id of a Tenant
     *
     * @param string $tenantId
     * @param integer $userId
     * @param bool $withTrashed included soft deleted record or not
     *
     * @return UserInterface|null
     */
    public function find(string $tenantId, int $userId, bool $withTrashed = false): ?UserInterface;

    /**
     * Find a User by Zone and Email
     *
     * @param string $tenantId
     * @param string $email
     * @param ZoneInterface $zone
     * @param bool $withTrashed included soft deleted record or not
     *
     * @return UserInterface|null
     */
    public function findByZoneAndEmail(string $tenantId, string $email, ZoneInterface $zone, bool $withTrashed = false): ?UserInterface;

    /**
     * Find a User by Zone and userName
     *
     * @param string $tenantId
     * @param string $userName
     * @param ZoneInterface $zone
     * @param bool $withTrashed included soft deleted record or not
     *
     * @return UserInterface|null
     */
    public function findByZoneAndUserName(string $tenantId, string $userName, ZoneInterface $zone, bool $withTrashed = false): ?UserInterface;

    /**
     * Add a User
     *
     * @param UserInterface $item
     *
     * @return UserInterface|null
     */
    public function insert(UserInterface $item): ?UserInterface;

    /**
     * Update a User
     *
     * @param UserInterface $item
     *
     * @return UserInterface|null
     */
    public function update(UserInterface $item): ?UserInterface;

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
     * Recover a Soft Deleted User
     *
     * @param string $tenantId
     * @param integer $userId
     *
     * @return boolean
     */
    public function recover(string $tenantId, int $userId): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return UserInterface|null
     */
    public function convertToEntity($data): ?UserInterface;
}
