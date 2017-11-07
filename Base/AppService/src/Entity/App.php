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

namespace Base\AppService\Entity;

use ReflectionClass;

/**
 * App Entity
 *
 * @package Base\AppService\Entity
 */
class App implements AppInterface
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
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $policies;

    /**
     * @var array
     */
    protected $plans;

    /**
     * @var array
     */
    protected $params;

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
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPolicies(array $policies)
    {
        $this->policies = $policies;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlans(array $plans)
    {
        $this->plans = $plans;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParams(array $params)
    {
        $this->params = $params;
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
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPolicies(): ?array
    {
        return $this->policies;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlans(): ?array
    {
        return $this->plans;
    }

    /**
     * {@inheritdoc}
     */
    public function getParams(): ?array
    {
        return $this->params;
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
