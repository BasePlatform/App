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
 * Tenant App Entity
 */
class TenantApp
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $tenantId;

    /**
     * @var string
     */
    protected $appId;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecretKey;

    /**
     * @var string
     */
    protected $selectedPlan;

    /**
     * @var array
     */
    protected $appParams;

    /**
     * @var array
     */
    protected $externalInfo;

    /**
     * @var array
     */
    protected $chargeInfo;

    /**
     * @var bool
     */
    protected $exceededPlanUsage = false;

    /**
     * @var integer
     */
    protected $exceededPlanAt;

    /**
     * @var bool
     */
    protected $planUpgradeRequired = false;

    /**
     * @var integer
     */
    protected $firstInstallAt;

    /**
     * @var integer
     */
    protected $recentInstallAt;

    /**
     * @var integer
     */
    protected $recentUninstallAt;

    /**
     * @var integer
     */
    protected $trialExpiresAt;

    /**
     * @var string
     */
    protected $status = 'disabled';

    /**
     * @var integer
     */
    protected $updatedAt;

    /**
     * Set the value of field id
     *
     * @param  integer $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the value of field tenantId
     *
     * @param  string $tenantId
     * @return $this
     */
    public function setTenantId(string $tenantId)
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * Set the value of field appId
     *
     * @param  string $appId
     * @return $this
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * Set the value of field apiKey
     *
     * @param  string $apiKey
     * @return $this
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * Set the value of field selectedPlan
     *
     * @param  string $selectedPlan
     * @return $this
     */
    public function setSelectedPlan(string $selectedPlan)
    {
        $this->selectedPlan = $selectedPlan;
        return $this;
    }

    /**
     * Set the value of field appParams
     *
     * @param  array $appParams
     * @return $this
     */
    public function setAppParams(array $appParams)
    {
        $this->appParams = $appParams;
        return $this;
    }

    /**
     * Set the value of field externalInfo
     *
     * @param  array $externalInfo
     * @return $this
     */
    public function setExternalInfo(array $externalInfo)
    {
        $this->externalInfo = $externalInfo;
        return $this;
    }

    /**
     * Set the value of field chargeInfo
     *
     * @param  array $chargeInfo
     * @return $this
     */
    public function setChargeInfo(array $chargeInfo)
    {
        $this->chargeInfo = $chargeInfo;
        return $this;
    }

    /**
     * Set the value of field exceededPlanUsage
     *
     * @param  bool $exceededPlanUsage
     * @return $this
     */
    public function setExceededPlanUsage(bool $exceededPlanUsage)
    {
        $this->exceededPlanUsage = $exceededPlanUsage;
        return $this;
    }

    /**
     * Set the value of field exceededPlanAt
     *
     * @param  integer $exceededPlanAt
     * @return $this
     */
    public function setExceededPlanAt(int $exceededPlanAt)
    {
        $this->exceededPlanAt = $exceededPlanAt;
        return $this;
    }

    /**
     * Set the value of field planUpgradeRequired
     *
     * @param  bool $planUpgradeRequired
     * @return $this
     */
    public function setPlanUpgradeRequired(bool $planUpgradeRequired)
    {
        $this->planUpgradeRequired = $planUpgradeRequired;
        return $this;
    }

    /**
     * Set the value of field firstInstallAt
     *
     * @param  integer $firstInstallAt
     * @return $this
     */
    public function setFirstInstalleAt(int $firstInstallAt)
    {
        $this->firstInstallAt = $firstInstallAt;
        return $this;
    }

    /**
     * Set the value of field recentInstallAt
     *
     * @param  integer $recentInstallAt
     * @return $this
     */
    public function setRecentInstallAt(int $recentInstallAt)
    {
        $this->recentInstallAt = $recentInstallAt;
        return $this;
    }

    /**
     * Set the value of field recentUninstallAt
     *
     * @param  integer $recentUninstallAt
     * @return $this
     */
    public function setRecentUninstallAt(int $recentUninstallAt)
    {
        $this->recentUninstallAt = $recentUninstallAt;
        return $this;
    }

    /**
     * Set the value of field trialExpiresAt
     *
     * @param  integer $trialExpiresAt
     * @return $this
     */
    public function setTrialExpiresAt(int $trialExpiresAt)
    {
        $this->trialExpiresAt = $trialExpiresAt;
        return $this;
    }

    /**
     * Set the value of field status
     *
     * @param  string $status
     * @return $this
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Set the value of field updatedAt
     *
     * @param  integer $updatedAt
     * @return $this
     */
    public function setUpdatedAt(int $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Return the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the value of field tenantId
     *
     * @return string
     */
    public function getTenantId()
    {
        return $this->tenantId;
    }

    /**
     * Return the value of field appId
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * Return the value of field apiKey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Return the value of field apiSecretKey
     *
     * @return string
     */
    public function getApiSecretKey()
    {
        return $this->apiSecretKey;
    }

    /**
     * Return the value of field selectedPlan
     *
     * @return string
     */
    public function getSelectedPlan()
    {
        return $this->selectedPlan;
    }

    /**
     * Return the value of field appParams
     *
     * @return array
     */
    public function getAppParams()
    {
        return $this->appParams;
    }

    /**
     * Return the value of field externalInfo
     *
     * @return array
     */
    public function getExternalInfo()
    {
        return $this->externalInfo;
    }

    /**
     * Return the value of field chargeInfo
     *
     * @return array
     */
    public function getChargeInfo()
    {
        return $this->chargeInfo;
    }

    /**
     * Return the value of field exceededPlanUsage
     *
     * @return bool
     */
    public function getExceededPlanUsage()
    {
        return $this->exceededPlanUsage;
    }

    /**
     * Return the value of field exceededPlanAt
     *
     * @return integer
     */
    public function getExceededPlanAt()
    {
        return $this->exceededPlanAt;
    }

    /**
     * Return the value of field planUpgradeRequired
     *
     * @return bool
     */
    public function getPlanUpgradeRequired()
    {
        return $this->planUpgradeRequired;
    }

    /**
     * Return the value of field firstInstallAt
     *
     * @return integer
     */
    public function getFirstInstallAt()
    {
        return $this->firstInstallAt;
    }

    /**
     * Return the value of field recentInstallAt
     *
     * @return integer
     */
    public function getRecentInstallAt()
    {
        return $this->recentInstallAt;
    }

    /**
     * Return the value of field recentUninstallAt
     *
     * @return integer
     */
    public function getRecentUninstallAt()
    {
        return $this->recentUninstallAt;
    }

    /**
     * Return the value of field trialExpiresAt
     *
     * @return integer
     */
    public function getTrialExpiresAt()
    {
        return $this->trialExpiresAt;
    }

    /**
     * Return the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Return the value of field updatedAt
     *
     * @return integer
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
