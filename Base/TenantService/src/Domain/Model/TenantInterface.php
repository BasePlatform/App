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

namespace Base\TenantService\Domain\Model;

use Base\Model\Entity\EntityInterface;

/**
 * Tenant Entity Interface
 *
 * @package Base\TenantService\Domain\Model
 */
interface TenantInterface extends EntityInterface
{
    /**
     * Activate Tenant
     *
     * @return $this
     */
    public function activate();

    /**
     * Disable Tenant
     *
     * @return $this
     */
    public function disable();

    /**
     * Return the value of field id
     *
     * @return TenantIdInterface
     */
    public function getId(): TenantIdInterface;

    /**
     * Return the value of field domain
     *
     * @return string
     */
    public function getDomain(): string;

    /**
     * Return the value of field platform
     *
     * @return string|null
     */
    public function getPlatform(): ?string;

    /**
     * Return the value of field isRootMember
     *
     * @return bool
     */
    public function getIsRootMember(): bool;

    /**
     * Return the value of field status
     *
     * @return TenantStatusInterface
     */
    public function getStatus(): TenantStatusInterface;

    /**
     * Return the value of field createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * Return the value of field updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;
}
