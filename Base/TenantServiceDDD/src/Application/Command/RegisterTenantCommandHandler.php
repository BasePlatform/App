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

use Base\Command\CommandHandlerInterface;

/**
 * Register a Tenant Command Handler
 *
 * @package Base\TenantService\Application\Command
 */
class RegisterTenantCommandHandler implements CommandHandlerInterface
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
     * @var RegisterTenantOwnerRequest
     */
    private $registerTenantOwnerRequest;

    /**
     * @param TenantMapperInterface      $dataMapper
     * @param TenantRepositoryInterface  $repository
     * @param TenantFactoryInterface     $factory
     * @param ValidatorInterface         $validator
     * @param RegisterTenantOwnerRequest $registerTenantOwnerRequest
     */
    public function __construct(
        TenantMapperInterface $dataMapper,
        TenantRepositoryInterface $repository,
        TenantFactoryInterface $factory,
        ValidatorInterface $validator,
        RegisterTenantOwnerRequest $registerTenantOwnerRequest
    ) {
        $this->dataMapper = $dataMapper;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->validator = $validator;
        $this->registerTenantOwnerRequest = $registerTenantOwnerRequest;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(CommandInterface $command)
    {
        // Get Info from $data
        $data = $command->getData();
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Create TenantId
        $tenantId = $this->factory->createTenantIdFromNameDomain($name, $command->getDomain());

        // Get Tenant
        $tenant = $this->repository->get($tenantId);

        if ($tenant) {
            throw new ExistedTenantException();
        } else {
            $unitOfWork = new UnitOfWork([
                $this->dataMapper
            ]);
            $tenant = $this->factory->create($tenantId);
            $tenant->register();

            // We should validate the Persistence Tenant Context here

            // Register as new and commit
            $unitOfWork->registerNew($tenant);
            $unitOfWork->commit();

            // Request Register Tenant Owner
            $serviceRequestResult = $this->registerTenantOwnerRequest->send([
                'tenantId' => (string) $tenantId,
                'email' => $email,
                'password' => $password
            ]);

            $successStatusCodes = [ResponseStatusCode::HTTP_OK, ResponseStatusCode::HTTP_CREATED];

            if (in_array($serviceRequestResult->getStatusCode(), $successStatusCodes)) {
                return $tenant;
            } else {
                // Failed, delete the inserted tenant
                $unitOfWork->registerDeleted($tenant);
                $unitOfWork->commit();
                throw new ServerErrorException(sprintf('Failed Registering Tenant `%s`', $tenantId));
            }
        }
    }
}
