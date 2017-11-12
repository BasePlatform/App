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

namespace Base\TenantService\Service;

/**
 * Tenant Service Interface
 *
 * @package Base\TenantService\Service
 */
interface TenantServiceInterface
{
    /**
     * 1. Create Tenant Info
     * 2. Send Request to Auth Service to create the Tenant Owner User Info
     * 2. Send Request to App Service Activate the default App
     *
     * @param array $data
     * @param string $appId
     * @param string $domain
     * @param string $platform
     *
     * @return mixed
     */
    public function register(array $data, string $appId, string $domain, string $platform = null);

    /**
     * Validate the data for service
     *
     * @param array $data
     * @param string $context The context of validation
     *
     * @return bool
     */
    public function validate(array $data, string $context = null);
}
