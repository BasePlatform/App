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

use Base\AuthService\Entity\ResourcePolicyAttachmentInterface;

/**
 * Resource Policy Attachment Repository Interface
 *
 * @package Base\AuthService\Repository
 */
interface ResourcePolicyAttachmentRepositoryInterface
{
    /**
     * Find all Attached Policies of a Resource Id of a Tenant
     *
     * @param string $tenantId
     * @param string $resourceId
     *
     * @return ResourcePolicyAttachmentInterface[]|null
     */
    public function findAll(string $tenantId, string $resourceId): ?array;

    /**
     * Add a record of Resource Policy Attachement
     *
     * @param ResourcePolicyAttachmentInterface $item
     *
     * @return integer|null The inserted Resource Policy Attachment Id
     */
    public function add(ResourcePolicyAttachmentInterface $item): ?integer;

    /**
     * Delete an Attached Policy of a Resource Id of a Tenant
     *
     * @param string $tenantId
     * @param string $resourceId
     * @param string $policyId
     *
     * @return boolean
     */
    public function delete(string $tenantId, string $resourceId, string $policyId): bool;

    /**
     * Delete all Attached Policies of a Resource Id of a Tenant
     *
     * @param string $tenantId
     * @param string $resourceId
     *
     * @return boolean
     */
    public function deleteAll(string $tenantId, string $resourceId): bool;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return ResourcePolicyAttachmentInterface|null
     */
    public function convertToEntity($data): ?ResourcePolicyAttachmentInterface;
}
