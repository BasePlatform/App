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

use Base\Helper\DateTimeHelper;

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
    protected $status;

    /**
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            // TenantId Required
            'tenantIdRequired' => ['tenantId', 'required'],
            // TenantId Length
            'tenantIdLength' => ['tenantId', ['stringType','length'], 'min' => 3, 'max' => 255],
            // selectedPlan Length
            'selectedPlanLength' => ['selectedPlan', ['stringType','length'], 'min' => 1, 'max' => 64],
            // AppId Required
            'appIdRequired' => ['appId', 'required'],
            // AppId Length
            'appIdLength' => ['id', ['stringType','length'], 'min' => 1, 'max' => 64],
            // Status Required
            'statusRequired' => ['status', 'required'],
            // Status Enum
            'statusEnum' => ['status', 'in', 'haystack'=> [self::STATUS_ACTIVE, self::STATUS_DISABLED]]
        ];
    }

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
    public function setSelectedPlan(string $selectedPlan = null)
    {
        $this->selectedPlan = $selectedPlan;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppParams(array $appParams = null)
    {
        $this->appParams = $appParams;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setExternalInfo(array $externalInfo = null)
    {
        $this->externalInfo = $externalInfo;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setChargeInfo(array $chargeInfo = null)
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
    public function setExceededPlanAt(\DateTime $exceededPlanAt = null)
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
    public function setFirstInstallAt(\DateTime $firstInstallAt = null)
    {
        $this->firstInstallAt = $firstInstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentInstallAt(\DateTime $recentInstallAt = null)
    {
        $this->recentInstallAt = $recentInstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setRecentUninstallAt(\DateTime $recentUninstallAt = null)
    {
        $this->recentUninstallAt = $recentUninstallAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTrialExpiresAt(\DateTime $trialExpiresAt = null)
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
    public function getId(): int
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
    public function getFirstInstallAt(): ?\DateTime
    {
        return $this->firstInstallAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentInstallAt(): ?\DateTime
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
        $reflector = new \ReflectionClass(get_class($this));
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

    /**
     * {@inheritdoc}
     */
    public function toArray(array $excludedAttributes = []): array
    {
        return array_diff_key([
            'id' => $this->id,
            'tenantId' => $this->tenantId,
            'appId' => $this->appId,
            'selectedPlan' => $this->selectedPlan,
            'appParams' => $this->appParams,
            'externalInfo' => $this->chargeInfo,
            'exceededPlanUsage' => $this->exceededPlanUsage,
            'exceededPlanAt' => DateTimeHelper::toISO8601($this->exceededPlanAt),
            'planUpgradeRequired' => $this->planUpgradeRequired,
            'firstInstallAt' => DateTimeHelper::toISO8601($this->firstInstallAt),
            'recentInstallAt' => DateTimeHelper::toISO8601($this->recentInstallAt),
            'recentUninstallAt' => DateTimeHelper::toISO8601($this->recentUninstallAt),
            'trialExpiresAt' => DateTimeHelper::toISO8601($this->trialExpiresAt),
            'status' => $this->status,
            'updatedAt' => DateTimeHelper::toISO8601($this->updatedAt)
        ], array_flip($excludedAttributes));
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
