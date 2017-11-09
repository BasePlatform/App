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

use Base\AuthService\ValueObject\ZoneInterface;

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
     * @param  string $id
     *
     * @return $this
     */
    public function setId(string $id);

    /**
     * Set the value of field type
     *
     * @param  string $type
     *
     * @return $this
     */
    public function setType(string $type);

    /**
     * Set the value of field zone
     *
     * @param  ZoneInterface $zone
     *
     * @return $this
     */
    public function setZone(ZoneInterface $zone);

    /**
     * Set the value of field appId
     *
     * @param  string $appId
     *
     * @return $this
     */
    public function setAppId(string $appId);

    /**
     * Set the value of field description
     *
     * @param  string $description
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
     * @return ZoneInterface
     */
    public function getZone(): ZoneInterface;

    /**
     * Return the value of field appId
     *
     * @return string
     */
    public function getAppId(): string;

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
}
