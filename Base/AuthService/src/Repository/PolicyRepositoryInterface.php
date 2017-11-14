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

use Base\AuthService\Entity\PolicyInterface;
use Base\AuthService\ValueObject\ZoneInterface;

/**
 * Policy Repository Interface
 *
 * @package Base\AuthService\Repository
 */
interface PolicyRepositoryInterface
{
    /**
     * Find Policy by Policy Id
     *
     * @param string $policyId
     *
     * @return PolicyInterface|null
     */
    public function find(string $policyId): ?PolicyInterface;

    /**
     * Find All Policies by App Id, Type, Zone
     *
     * @param string $appId
     * @param string $type
     * @param ZoneInterface $zone
     *
     * @return PolicyInterface[]|null
     */
    public function findAllByAppTypeZone(string $appId, string $type, ZoneInterface $zone): ?array;

    /**
     * Insert a Policy
     *
     * @param PolicyInterface $item
     *
     * @return PolicyInterface|null
     */
    public function insert(PolicyInterface $item): ?PolicyInterface;

    /**
     * Delete a Policy by Policy Id
     *
     * @param string $policyId
     *
     * @return boolean
     */
    public function delete(string $policyId): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return PolicyInterface|null
     */
    public function convertToEntity($data): ?PolicyInterface;
}
