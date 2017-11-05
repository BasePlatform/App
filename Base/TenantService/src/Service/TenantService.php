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
use Base\TenantService\Factory\TenantFactoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfoException;
use Base\TenantService\Exception\NotActiveTenantException;
use Base\ServiceRequest\ServiceRequestInterface;

/**
 * Tenant Service
 *
 * @package Base\TenantService\Service
 */
class TenantService implements TenantServiceInterface
{
    /**
     * @var TenantRepositoryInterface
     */
    private $tenantRepository;

    /**
     * @var TenantIdFactoryInterface
     */
    private $tenantIdFactory;

    /**
     * @var TenantFactoryInterface
     */
    private $tenantFactory;

    /**
     * @var ServiceRequestInterface
     */
    private $serviceRequest;

    /**
     * @param TenantRepositoryInterface $tenantRepository
     */
    public function __construct(TenantRepositoryInterface $tenantRepository, ServiceRequestInterface $serviceRequest, TenantIdFactoryInterface $tenantIdFactory, TenantFactoryInterface $tenantFactory)
    {
        $this->tenantRepository = $tenantRepository;
        $this->serviceRequest = $serviceRequest;
        $this->tenantIdFactory = $tenantIdFactory;
        $this->tenantFactory = $tenantFactory;
    }

    /**
     * @param array $data
     * @param string $domain
     *
     * @return mixed
     */
    public function register(array $data, string $domain, string $platform = null)
    {
        // Get Info from $data
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Validate the Data here

        // Create TenantId
        $tenantId = call_user_func_array([$this->tenantIdFactory->getClassName(), 'create'], [$name, $domain]);

        $tenant = $this->tenantRepository->get($tenantId);
        if (!$tenant || ($tenant && $tenant->getStatusOptions('STATUS_ACTIVE') == $tenant->getStatus())) {
            // So we could go ahead with current registration info

            // No Tenant Record? Add it
            if (!$tenant) {
                $nowTime = time();
                $tenant = $this->tenantFactory->createNew();
                $tenant->setId($tenantId);
                $tenant->setDomain((string) $tenantId);
                $tenant->setPlatform($platform);
                $tenant->setStatus($tenant->getStatusOptions('STATUS_ACTIVE'));
                $tenant->setCreatedAt($nowTime);
                $tenant->setupdatedAt($nowTime);
                $this->tenantRepository->add($tenant);
            }

            // Call to other services to finish the registration process

            // Prepare data to send to other services
            $options = [
              'json' => [
                'tenantId' => (string) $tenantId,
                'appId' => 'default'
              ]
            ];

            $result = $this->serviceRequest->send('APP_SERVICE', 'activateAppEndpoint', $options, true);

            $result = $this->serviceRequest->send('AUTH_SERVICE', 'activateAppEndpoint', $options, true);

            return json_decode($result->getBody()->getContents(), true);

            // $this->serviceRequest->send('AUTH_SERVICE', 'registerTenantOwnerEndpoint', $options, true);
            // $this->serviceRequest->request(['/app/default/activate']);
            // $this->serviceRequest->request(['/user/create']);
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
