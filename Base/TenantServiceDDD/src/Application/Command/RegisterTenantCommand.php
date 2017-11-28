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

namespace Base\TenantService\Application\Command;

use Base\Command\CommandInterface;

/**
 * Register a Tenant Command
 *
 * @package Base\TenantService\Application\Command
 */
class RegisterTenantCommand implements CommandInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $appDomain;

    /**
     * @param array       $data
     * @param string      $appId
     * @param string      $appDomain
     */
    public function __construct(array $data, string $appId, string $appDomain)
    {
        $this->data = $data;
        $this->appId = $appId;
        $this->appDomain = $appDomain;
    }

    /**
     * Return data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Return appId
     *
     * @return string
     */
    public function getAppId(): string
    {
        return $this->appId;
    }

    /**
     * Return appDomain
     *
     * @return string
     */
    public function getAppDomain(): string
    {
        return $this->appDomain;
    }
}
