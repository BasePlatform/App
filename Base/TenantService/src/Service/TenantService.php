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

use Base\TenantService\ValueObject\TenantId;
use Base\TenantService\Repository\TenantRepositoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfodException;

/**
 * Tenant Service
 *
 * @package Base\TenantService\Service
 */
class TenantService implements TenantServiceInterface
{

  private $tenantRepository;

  /**
   * @param array $data
   * @param string $domain
   *
   * @return mixed
   */
  public function register(array $data, string $domain)
  {
    // Do the step to register the data
    $tenantName = $data['tenantName'] ?? '';
    $tenantEmail = $data['tenantEmail'] ?? '';
    $tenantPassword = $data['tenantPassword'] ?? '';
    if (empty($tenantName)) {
      throw new InvalidTenantRegistrationInfodException('Empty Tenant Name');
    }
    if (empty($tenantEmail)) {
      throw new InvalidTenantRegistrationInfodException('Empty/Invalid Email');
    }
    if (empty($tenantPassword)) {
      throw new InvalidTenantRegistrationInfodException('Empty/Invalid Password');
    }

    $tenantId = TenantId::create($name, $domain);

    return [
      'tenantId' => $tenantId
    ];
    // 1. Create the TenantId
    //
    // 2. Get Tenant Info Based on Tenant
    //
    // 3. Check Tenant Installed the App
    //
    // 4. Check Tenant Status
    //
    //  + Disabled: We stop processing the request
    //
    //  + Active or no Tenant Record: Continue
    //
    // 5. Check TenantApp Status
    //
    //  + Disabled: We stop processing the request
    //
    //  + Active or no Tenant Record: Continue
    //
    // 6. Process Registration Process
    //
    //  + Create Tenant
    //
    //  + Communicate to App Service to Activate the App
    //
    //  + Communicate to Auth Service to Create Owner Account
    //
    //  7. Return the Response
  }
}
