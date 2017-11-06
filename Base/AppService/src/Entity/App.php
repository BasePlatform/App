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
class App
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
    protected $roles;

    /**
     * @var array
     */
    protected $params;

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
     * @param  string $id
     * @return $this
     */
    public function setId(string $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Set the value of field roles
     *
     * @param  array $roles
     * @return $this
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Set the value of field params
     *
     * @param  array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Return the value of field roles
     *
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * Return the value of field params
     *
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * Return the value of field status
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Return the value of field updatedAt
     *
     * @return integer
     */
    public function getUpdatedAt(): int
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
