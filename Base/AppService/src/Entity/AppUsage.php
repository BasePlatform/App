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
 * App Usage Entity
 *
 * @package Base\AppService\Entity
 */
class AppUsage implements AppUsageInterface
{
    /**
     * Active Status
     */
    const STATUS_ACTIVE = 'active';

    /**
     * Disabled Status
     */
    const STATUS_DISABLED = 'disabled';

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
     * @var \DateTime
     */
    protected $exceededPlanAt;

    /**
     * @var bool
     */
    protected $planUpgradeRequired = false;

    /**
     * @var \DateTime
     */
    protected $firstInstallAt;

    /**
     * @var \DateTime
     */
    protected $recentInstallAt;

    /**
     * @var \DateTime
     */
    protected $recentUninstallAt;

    /**
     * @var \DateTime
     */
    protected $trialExpiresAt;

    /**
     * @var string
     */
    protected $status = 'disabled';

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTenantId(string $tenantId)
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setSelectedPlan(string $selectedPlan)
    {
        $this->selectedPlan = $selectedPlan;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppParams(array $appParams)
    {
        $this->appParams = $appParams;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setExternalInfo(array $externalInfo)
    {
        $this->externalInfo = $externalInfo;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setChargeInfo(array $chargeInfo)
    {
        $this->chargeInfo = $chargeInfo;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setExceededPlanUsage(bool $exceededPlanUsage)
    {
        $this->exceededPlanUsage = $exceededPlanUsage;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setExceededPlanAt(\DateTime $exceededPlanAt)
    {
        $this->exceededPlanAt = $exceededPlanAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlanUpgradeRequired(bool $planUpgradeRequired)
    {
        $this->planUpgradeRequired = $planUpgradeRequired;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstInstallAt(\DateTime $firstInstallAt)
    {
        $this->firstInstallAt = $firstInstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentInstallAt(\DateTime $recentInstallAt)
    {
        $this->recentInstallAt = $recentInstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentUninstallAt(\DateTime $recentUninstallAt)
    {
        $this->recentUninstallAt = $recentUninstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTrialExpiresAt(\DateTime $trialExpiresAt)
    {
        $this->trialExpiresAt = $trialExpiresAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): integer
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSelectedPlan(): ?string
    {
        return $this->selectedPlan;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppParams(): ?array
    {
        return $this->appParams;
    }

    /**
     * {@inheritdoc}
     */
    public function getExternalInfo(): ?array
    {
        return $this->externalInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getChargeInfo(): ?array
    {
        return $this->chargeInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function getExceededPlanUsage(): bool
    {
        return $this->exceededPlanUsage;
    }

    /**
     * {@inheritdoc}
     */
    public function getExceededPlanAt(): ?\DateTime
    {
        return $this->exceededPlanAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlanUpgradeRequired(): bool
    {
        return $this->planUpgradeRequired;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstInstallAt(): \DateTime
    {
        return $this->firstInstallAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentInstallAt(): \DateTime
    {
        return $this->recentInstallAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentUninstallAt(): ?\DateTime
    {
        return $this->recentUninstallAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getTrialExpiresAt(): ?\DateTime
    {
        return $this->trialExpiresAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusOptions(string $status = null)
    {
        $reflector = new ReflectionClass(get_class($this));
        $constants = $reflector->getConstants();
        $result = [];
        foreach ($constants as $constant => $value) {
            if (!empty($status) && $constant == $status) {
                $result = $value;
                break;
            }
            $prefix = "STATUS_";
            if (strpos($constant, $prefix) !==false) {
                $result[] = $value;
            }
        }
        return $result;
    }
}
