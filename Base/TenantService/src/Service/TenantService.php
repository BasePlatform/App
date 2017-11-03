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
use Base\TenantService\Factory\TenantIdFactoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfoException;
use Base\TenantService\Exception\NotActiveTenantException;

/**
 * Tenant Service
 *
 * @package Base\TenantService\Service
 */
class TenantService implements TenantServiceInterface
{
  /**
   * Active Status of Tenant
   */
  const STATUS_ACTIVE = 'active';

  /**
   * Disabled Status of Tenant
   */
  const STATUS_DISABLED = 'disabled';

  /**
   * @var TenantRepositoryInterface
   */
  private $tenantRepository;

  /**
   * @var TenantIdFactoryInterface
   */
  private $tenantIdFactory;

  /**
   * @param TenantRepositoryInterface $tenantRepository
   */
  public function __construct(TenantRepositoryInterface $tenantRepository, TenantIdFactoryInterface $tenantIdFactory)
  {
    $this->tenantRepository = $tenantRepository;
    $this->tenantIdFactory = $tenantIdFactory;
  }

  /**
   * @param array $data
   * @param string $domain
   *
   * @return mixed
   */
  public function register(array $data, string $domain)
  {
    // Do the step to register the data
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // if (empty($tenantName)) {
    //   throw new InvalidTenantRegistrationInfodException('Empty Tenant Name');
    // }
    // if (empty($tenantEmail)) {
    //   throw new InvalidTenantRegistrationInfodException('Empty/Invalid Email');
    // }
    // if (empty($tenantPassword)) {
    //   throw new InvalidTenantRegistrationInfodException('Empty/Invalid Password');
    // }

    $tenantId = call_user_func_array([$this->tenantIdFactory->getClassName(), 'create'], [$name, $domain]);

    // Validate the Info here

    $tenant = $this->tenantRepository->findOneById($tenantId);
    if (!$tenant || ($tenant && $tenant->getStatus() == self::STATUS_ACTIVE)) {
      // So we could go ahead with current registration info
      // $this->tenantRepository->store();
      // $this->serviceRequest->request(['/app/default/activate']);
      // $this->serviceRequest->request(['/user/create']);
      echo 'hehehe';

    } else {
      throw new NotActiveTenantException();
    }

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

  /**
   * Validate the data for service
   *
   * @param array $data
   * @param string $context The context of validation
   *
   * @return bool
   */
  public function validate(array $data, string $context = null)
  {

  }
}
