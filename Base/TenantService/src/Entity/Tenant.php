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

namespace Base\TenantService\Entity;

use Ramsey\Uuid\Uuid;
use ReflectionClass;

/**
 * Tenant Entity
 *
 * @package Base\TenantService\Entity
 */
class Tenant implements TenantInterface
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
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $platform;

    /**
     * @var string
     */
    protected $timeZone;

    /**
     * @var string
     */
    protected $status = 'disabled';

    /**
     * @var \DateTime
     */
    protected $createdAt;

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
    public function setDomain(string $domain)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPlatform(string $platform = null)
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimeZone(string $timeZone = 'UTC')
    {
        $this->timeZone = $timeZone;
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
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
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
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * {@inheritdoc}
     */
    public function getPlatform(): string
    {
        return $this->platform;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeZone(): string
    {
        return $this->timeZone;
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
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
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

    /**
     * {@inheritdoc}
     */
    public static function createTenantId(string $name = '', string $domain = ''): string
    {
        if (!empty($name)) {
            return $name.$domain;
        } else {
            $uuid = Uuid::uuid4()->toString();
            return $uuid.$domain;
        }
    }
}
