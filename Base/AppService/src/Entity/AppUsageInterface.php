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

namespace Base\AppService\Entity;

/**
 * App Usage Entity Interface
 *
 * @package Base\AppService\Entity
 */
interface AppUsageInterface
{
    /**
     * Set the value of field id
     *
     * @param  integer $id
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
     * Set the value of field appId
     *
     * @param  string $appId
     * @return $this
     */
    public function setAppId(string $appId);

    /**
     * Set the value of field selectedPlan
     *
     * @param  string|null $selectedPlan
     * @return $this
     */
    public function setSelectedPlan(string $selectedPlan = null);

    /**
     * Set the value of field appParams
     *
     * @param  array|null $appParams
     * @return $this
     */
    public function setAppParams(array $appParams = null);

    /**
     * Set the value of field externalInfo
     *
     * @param  array|null $externalInfo
     * @return $this
     */
    public function setExternalInfo(array $externalInfo = null);

    /**
     * Set the value of field chargeInfo
     *
     * @param  array|null $chargeInfo
     * @return $this
     */
    public function setChargeInfo(array $chargeInfo = null);
    /**
     * Set the value of field exceededPlanUsage
     *
     * @param  bool $exceededPlanUsage
     * @return $this
     */
    public function setExceededPlanUsage(bool $exceededPlanUsage);

    /**
     * Set the value of field exceededPlanAt
     *
     * @param  \DateTime|null $exceededPlanAt
     * @return $this
     */
    public function setExceededPlanAt(\DateTime $exceededPlanAt = null);

    /**
     * Set the value of field planUpgradeRequired
     *
     * @param  bool $planUpgradeRequired
     * @return $this
     */
    public function setPlanUpgradeRequired(bool $planUpgradeRequired);

    /**
     * Set the value of field firstInstallAt
     *
     * @param  \DateTime|null $firstInstallAt
     * @return $this
     */
    public function setFirstInstallAt(\DateTime $firstInstallAt = null);

    /**
     * Set the value of field recentInstallAt
     *
     * @param  \DateTime|null $recentInstallAt
     * @return $this
     */
    public function setRecentInstallAt(\DateTime $recentInstallAt = null);

    /**
     * Set the value of field recentUninstallAt
     *
     * @param  \DateTime|null $recentUninstallAt
     * @return $this
     */
    public function setRecentUninstallAt(\DateTime $recentUninstallAt = null);

    /**
     * Set the value of field trialExpiresAt
     *
     * @param  \DateTime|null $trialExpiresAt
     * @return $this
     */
    public function setTrialExpiresAt(\DateTime $trialExpiresAt = null);

    /**
     * Set the value of field status
     *
     * @param  string $status
     * @return $this
     */
    public function setStatus(string $status);

    /**
     * Set the value of field updatedAt
     *
     * @param  \DateTime $updatedAt
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt);

    /**
     * Return the value of field id
     *
     * @return integer
     */
    public function getId(): int;

    /**
     * Return the value of field tenantId
     *
     * @return string
     */
    public function getTenantId(): string;

    /**
     * Return the value of field appId
     *
     * @return string
     */
    public function getAppId(): string;

    /**
     * Return the value of field selectedPlan
     *
     * @return string|null
     */
    public function getSelectedPlan(): ?string;

    /**
     * Return the value of field appParams
     *
     * @return array|null
     */
    public function getAppParams(): ?array;

    /**
     * Return the value of field externalInfo
     *
     * @return array|null
     */
    public function getExternalInfo(): ?array;

    /**
     * Return the value of field chargeInfo
     *
     * @return array|null
     */
    public function getChargeInfo(): ?array;

    /**
     * Return the value of field exceededPlanUsage
     *
     * @return bool
     */
    public function getExceededPlanUsage(): bool;

    /**
     * Return the value of field exceededPlanAt
     *
     * @return \DateTime|null
     */
    public function getExceededPlanAt(): ?\DateTime;

    /**
     * Return the value of field planUpgradeRequired
     *
     * @return bool
     */
    public function getPlanUpgradeRequired(): bool;

    /**
     * Return the value of field firstInstallAt
     *
     * @return \DateTime
     */
    public function getFirstInstallAt(): ?\DateTime;

    /**
     * Return the value of field recentInstallAt
     *
     * @return \DateTime
     */
    public function getRecentInstallAt(): ?\DateTime;

    /**
     * Return the value of field recentUninstallAt
     *
     * @return \DateTime|null
     */
    public function getRecentUninstallAt(): ?\DateTime;

    /**
     * Return the value of field trialExpiresAt
     *
     * @return \DateTime|null
     */
    public function getTrialExpiresAt(): ?\DateTime;

    /**
     * Return the value of field status
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * Return the value of field updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime;

    /**
     * Get Status Options from Constants
     * If $status is passed, it will return the value of the status constant
     *
     * @param  string $status
     *
     * @return array|string
     */
    public function getStatusOptions(string $status = null);
}
