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

namespace Base\AppService\Domain\App;

/**
 * App Entity
 */
class AppEntity
{
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
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the value of field roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Return the value of field params
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
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
