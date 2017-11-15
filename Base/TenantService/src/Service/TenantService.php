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
use Base\TenantService\Factory\TenantFactoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfoException;
use Base\TenantService\Exception\ExistedTenantException;
use Base\ServiceRequest\ServiceRequestInterface;
use Base\Helper\DateTimeHelper;
use Base\Http\ResponseStatusCode;

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
    private $repository;

    /**
     * @var TenantFactoryInterface
     */
    private $factory;

    /**
     * @var ServiceRequestInterface
     */
    private $serviceRequest;

    /**
     * @param TenantRepositoryInterface $repository
     * @param TenantFactoryInterface $factory
     * @param ServiceRequestInterface $serviceRequest
     */
    public function __construct(
        TenantRepositoryInterface $repository,
        TenantFactoryInterface $factory,
        ServiceRequestInterface $serviceRequest
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function register(array $data, string $appId, string $domain, string $platform = null)
    {
        // Get Info from $data
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Validate the Data here

        // Create TenantId
        $tenantId = call_user_func_array([$this->factory->getTenantIdClassName(), 'createTenantId'], [$name, $domain]);

        // Get Tenant
        $tenant = $this->repository->find($tenantId);

        if ($tenant) {
            throw new ExistedTenantException();
        } else {
            $nowTime = DateTimeHelper::now();
            $tenant = $this->factory->create();
            $tenant->setId($tenantId);
            $tenant->setDomain((string) $tenantId);
            $tenant->setPlatform($platform);
            $tenant->setStatus($tenant->getStatusOptions('STATUS_ACTIVE'));
            $tenant->setCreatedAt($nowTime);
            $tenant->setupdatedAt($nowTime);
            $tenant = $this->repository->insert($tenant);

            if ($tenant) {
              // Call to other services to finish the registration process
              // Prepare data to send to other services
                $options = [
                  'json' => [
                    'tenantId' => (string) $tenantId,
                    'appId' => $appId,
                    'email' => $email,
                    'password' => $password,
                    'authProvider' => 'app'
                  ]
                ];

                $activateAppResult = $this->serviceRequest->send('APP_SERVICE', 'app.system.activateAppEndpoint', $options, true);

                $registerTenantOwnerResult = $this->serviceRequest->send('AUTH_SERVICE', 'auth.system.registerTenantOwnerEndpoint', $options, true);

                if ($activateAppResult->getStatusCode() == ResponseStatusCode::HTTP_OK && $registerTenantOwnerResult->getStatusCode() == ResponseStatusCode::HTTP_OK) {
                    return $tenant;
                }
            }
            throw new ServerErrorException(sprintf('Failed Registering Tenant `%s` Tenant `%s`', $tenantId));
        }
    }

    /**
     * Validate the data for service
     *
     * @param array $data
     * @param array $rules
     * @param string $context The context of validation
     *
     * @return bool
     */
    protected function validate(array $data, array $rules, string $context = null)
    {
    }
}
