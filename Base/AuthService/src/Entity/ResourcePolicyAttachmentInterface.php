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

namespace Base\AuthService\Entity;

/**
 * Resource Policy Attachment Entity Interface
 *
 * @package Base\AuthService\Entity
 */
interface ResourcePolicyAttachmentInterface
{
    /**
     * Set the value of field id
     *
     * @param  int $id
     * @return $this
     */
    public function setId(int $id);

    /**
     * Set the value of field tenantId
     *
     * @param  string $tenantId
     * @return $this
     */
    public function setTenantId(string $tenantId);

    /**
     * Set the value of field zone
     *
     * @param  string $zone
     * @return $this
     */
    public function setZone(string $zone);

    /**
     * Set the value of field resourceId
     *
     * @param  string $resourceId
     * @return $this
     */
    public function setResourceId(string $resourceId);

    /**
     * Set the value of field policy
     *
     * @param  string $policy
     * @return $this
     */
    public function setPolicy(string $policy);

    /**
     * Set the value of field policyParams
     *
     * @param  array $policyParams
     * @return $this
     */
    public function setPolicyParams(array $policyParams);

    /**
     * Set the value of field attachedAt
     *
     * @param  \DateTime $attachedAt
     * @return $this
     */
    public function setAttachedAt(\DateTime $attachedAt);

    /**
     * Return the value of field id
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Return the value of field tenantId
     *
     * @return string
     */
    public function getTenantId(): string;

    /**
     * Return the value of field zone
     *
     * @return string
     */
    public function getZone(): string;

    /**
     * Return the value of field resourceId
     *
     * @return string
     */
    public function getResourceId(): string;

    /**
     * Return the value of field policy
     *
     * @return string
     */
    public function getPolicy(): string;

    /**
     * Return the value of field policyParams
     *
     * @return array|null
     */
    public function getPolicyParams(): ?array;

    /**
     * Return the value of field attachedAt
     *
     * @return \DateTime
     */
    public function getAttachedAt(): \DateTime;

    /**
     * Create a Resource Id based on type and id
     *
     * @return string
     */
    public static function createResourceId(string $type, string $id): string;
}
