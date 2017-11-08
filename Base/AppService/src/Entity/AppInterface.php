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

/**
 * App Entity Interface
 *
 * @package Base\AppService\Entity
 */
interface AppInterface
{
    /**
     * Set the value of field id
     *
     * @param  string $id
     * @return $this
     */
    public function setId(string $id);

    /**
     * Set the value of field plans
     *
     * @param  array $plans
     * @return $this
     */
    public function setPlans(array $plans);

    /**
     * Set the value of field params
     *
     * @param  array $params
     * @return $this
     */
    public function setParams(array $params);

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
     * @return string
     */
    public function getId(): string;

    /**
     * Return the value of field plans
     *
     * @return array|null
     */
    public function getPlans(): ?array;

    /**
     * Return the value of field params
     *
     * @return array|null
     */
    public function getParams(): ?array;

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
