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
use Base\Formatter\DateTimeFormatter;

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
    public function __construct(TenantRepositoryInterface $tenantRepository, ServiceRequestInterface $serviceRequest, TenantFactoryInterface $tenantFactory)
    {
        $this->tenantRepository = $tenantRepository;
        $this->serviceRequest = $serviceRequest;
        $this->tenantFactory = $tenantFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function register(array $data, string $domain, string $platform = null, string $timeZone = 'UTC')
    {
        // Get Info from $data
        $name = $data['name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Validate the Data here

        // Create TenantId
        $tenantId = call_user_func_array([$this->tenantFactory->getTenantIdClassName(), 'createTenantId'], [$name, $domain]);

        // Get Tenant
        $tenant = $this->tenantRepository->get($tenantId);

        if ($tenant) {
            // throw new ExistedTenantException();
            $options = [
              'json' => [
                'tenantId' => (string) $tenantId,
                'appId' => 'default',
                'email' => $email,
                'password' => $password,
                'attachedPolicies' => ['tenant.tenantOwner']
              ]
            ];
            return $options;
        } else {
            $nowTime = DateTimeFormatter::now();
            $tenant = $this->tenantFactory->create();
            $tenant->setId($tenantId);
            $tenant->setDomain((string) $tenantId);
            $tenant->setPlatform($platform);
            $tenant->setTimeZone($timeZone);
            $tenant->setStatus($tenant->getStatusOptions('STATUS_ACTIVE'));
            $tenant->setCreatedAt($nowTime);
            $tenant->setupdatedAt($nowTime);
            $this->tenantRepository->add($tenant);

            // Call to other services to finish the registration process
            // Prepare data to send to other services
            $options = [
              'json' => [
                'tenantId' => (string) $tenantId,
                'appId' => 'default',
                'email' => $email,
                'password' => $password,
                'attachedPolicies' => ['tenant.tenantOwner']
              ]
            ];

            // $activateAppresult = $this->serviceRequest->send('APP_SERVICE', 'activateAppEndpoint', $options, true);

            // $result = $this->serviceRequest->send('AUTH_SERVICE', 'activateAppEndpoint', $options, true);

            //return json_decode($result->getBody()->getContents(), true);
            //
            return $options;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $data, string $context = null)
    {
    }
}
