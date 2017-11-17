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

use Base\Common\ValueObject\TenantIdInterface;
use Base\Common\Factory\TenantIdFactoryInterface;
use Base\TenantService\Repository\TenantRepositoryInterface;
use Base\TenantService\Factory\TenantFactoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfoException;
use Base\TenantService\Exception\ExistedTenantException;
use Base\Validator\ValidatorInterface;
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
     * @var TenantIdFactoryInterface
     */
    private $tenantIdFactory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ServiceRequestInterface
     */
    private $serviceRequest;

    /**
     * @param TenantRepositoryInterface $repository
     * @param TenantFactoryInterface $factory
     * @param TenantIdFactoryInterface $tenantIdFactory
     * @param ServiceRequestInterface $serviceRequest
     */
    public function __construct(
        TenantRepositoryInterface $repository,
        TenantFactoryInterface $factory,
        TenantIdFactoryInterface $tenantIdFactory,
        ValidatorInterface $validator,
        ServiceRequestInterface $serviceRequest
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->tenantIdFactory = $tenantIdFactory;
        $this->validator = $validator;
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function register(array $data, string $appId, string $domain, string $platform = null): ?TenantInterface
    {
        // Get Info from $data
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Validate the Data here
        $this->validator->validate($data, [
          'name' => ['name', ['stringType', 'length'], 'min' => 3, 'max' => 255],
          'email' => ['email', ['required','stringType','length'], 'min' => 7, 'max' => 255],
          'emailFormat' => ['email', 'email', 'message' => 'Tuan uses email']
        ]);

        var_dump($this->validator->errors);
        exit;

        // Create TenantId
        $tenantId = call_user_func_array([$this->tenantIdFactory->getClassName(), 'createFromStringNameDomain'], [$name, $domain]);

        // Get Tenant
        $tenant = $this->repository->find($tenantId);

        if ($tenant) {
            throw new ExistedTenantException();
        } else {
            $now = DateTimeHelper::now();
            $tenant = $this->factory->create();
            $tenant->setId($tenantId);
            $tenant->setDomain((string) $tenantId);
            $tenant->setPlatform($platform);
            $tenant->setIsRootMember(false);
            $tenant->setStatus($tenant->getStatusOptions('STATUS_ACTIVE'));
            $tenant->setCreatedAt($now);
            $tenant->setupdatedAt($now);
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
            throw new ServerErrorException(sprintf('Failed Registering Tenant `%s`', $tenantId));
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
