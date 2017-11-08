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

namespace Base\AuthService\Entity;

/**
 * Policy Entity Interface
 *
 * @package Base\AuthService\Entity
 */
interface PolicyInterface
{
    /**
     * Set the value of field id
     *
     * @param  array $id
     *
     * @return $this
     */
    public function setId(string $id);

    /**
     * Set the value of field type
     *
     * @param  array $type
     *
     * @return $this
     */
    public function setType(string $type);

    /**
     * Set the value of field zone
     *
     * @param  array $zone
     *
     * @return $this
     */
    public function setZone(string $zone);

    /**
     * Set the value of field service
     *
     * @param  array $service
     *
     * @return $this
     */
    public function setService(string $service);

    /**
     * Set the value of field description
     *
     * @param  array $description
     *
     * @return $this
     */
    public function setDescription(string $description);

    /**
     * Set the value of field params
     *
     * @param  array $params
     *
     * @return $this
     */
    public function setParams(array $params);

    /**
     * Return the value of field id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Return the value of field type
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Return the value of field zone
     *
     * @return string
     */
    public function getZone(): string;

    /**
     * Return the value of field service
     *
     * @return string
     */
    public function getService(): string;

    /**
     * Return the value of field description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Return the value of field params
     *
     * @return array|null
     */
    public function getParams(): ?array;

    /**
     * Get Zone Options from Constants
     * If $zone is passed, it will return the value of the status constant
     *
     * @param  string $zone
     *
     * @return array|string
     */
    public function getZoneOptions(string $zone = null);
}
