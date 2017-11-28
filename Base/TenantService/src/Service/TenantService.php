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

use Base\TenantService\Model\TenantInterface;
use Base\TenantService\Model\TenantFactoryInterface;
use Base\TenantService\DataMapper\TenantMapperInterface;
use Base\TenantService\Repository\TenantRepositoryInterface;
use Base\TenantService\Exception\InvalidTenantRegistrationInfoException;
use Base\TenantService\Exception\ExistedTenantException;
use Base\UnitOfWork\UnitOfWork;
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
     * @var TenantMapperInterface
     */
    private $dataMapper;

    /**
     * @var TenantRepositoryInterface
     */
    private $repository;

    /**
     * @var TenantFactoryInterface
     */
    private $factory;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ServiceRequestInterface
     */
    private $serviceRequest;

    /**
     * @param TenantMapperInterface $dataMapper
     * @param TenantRepositoryInterface $repository
     * @param TenantFactoryInterface $factory
     * @param ValidatorInterface $validator
     * @param ServiceRequestInterface $serviceRequest
     */
    public function __construct(
        TenantMapperInterface $dataMapper,
        TenantRepositoryInterface $repository,
        TenantFactoryInterface $factory,
        ValidatorInterface $validator,
        ServiceRequestInterface $serviceRequest
    ) {
        $this->dataMapper = $dataMapper;
        $this->repository = $repository;
        $this->factory = $factory;
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

        return $this->factory->create();

        // Validate the Data here
        $this->validator->validate($data, [
          'name' => ['name', ['stringType', 'length'], 'min' => 3, 'max' => 255],
          'email' => ['email', ['required','stringType','length'], 'min' => 7, 'max' => 255],
          'emailFormat' => ['email', 'email', 'message' => 'Tuan uses email']
        ]);

        var_dump($this->validator->errors);
        exit;

        // Create TenantId
        $tenantId = call_user_func_array([$this->factory->getTenantIdClassName(), 'createFromStringNameDomain'], [$name, $domain]);

        // Get Tenant
        $tenant = $this->repository->get($tenantId);

        if ($tenant) {
            throw new ExistedTenantException();
        } else {
            // Create UnitOfWork
            $unitOfWork = new UnitOfWork([
                $this->dataMapper
            ]);
            $now = DateTimeHelper::now();
            $tenant = $this->factory->create();
            $tenant->setId($tenantId);
            $tenant->setDomain((string) $tenantId);
            $tenant->setPlatform($platform);
            // Not a Root Member - For Sure
            $tenant->setIsRootMember(false);
            $tenant->setStatus($this->factory->createTenantStatus('STATUS_ACTIVE'));
            $tenant->setCreatedAt($now);
            $tenant->setupdatedAt($now);

            // We should validate the Persistence Tenant Context here

            // Register as new and commit
            $unitOfWork->registerNew($tenant);
            $unitOfWork->commit();

            // Prepare service data and call other services
            $serviceRequestData = [
              'json' => [
                'tenantId' => (string) $tenantId,
                'appId' => $appId,
                'email' => $email,
                'password' => $password,
                'authProvider' => 'app'
              ]
            ];
            // Request Activate App
            $activateAppResult = $this->serviceRequest->send('APP_SERVICE', 'app.system.activateAppEndpoint', $serviceRequestData, true);
            // Request Register Tenant Owner
            $registerTenantOwnerResult = $this->serviceRequest->send('AUTH_SERVICE', 'auth.system.registerTenantOwnerEndpoint', $serviceRequestData, true);

            $successStatusCodes = [ResponseStatusCode::HTTP_OK, ResponseStatusCode::HTTP_CREATED];

            if (in_array($activateAppResult->getStatusCode(), $successStatusCodes) &&
              in_array($activateAppResult->getStatusCode(), $successStatusCodes)) {
                return $tenant;
            } else {
                // Failed, delete the inserted tenant
                $unitOfWork->registerDeleted($tenant);
                $unitOfWork->commit();
                throw new ServerErrorException(sprintf('Failed Registering Tenant `%s`', $tenantId));
            }
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
