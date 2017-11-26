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

namespace Base\TenantService\Application\Service;

/**
 * Register Tenant Owner Request
 *
 * @package Base\TenantService\Application\Service
 */
class RegisterTenantOwnerRequest
{
    /**
     * @var ServiceRequestInterface
     */
    private $serviceRequest;

    /**
     * @param ServiceRequestInterface $serviceRequest
     */
    public function __construct(ServiceRequestInterface $serviceRequest)
    {
        $this->serviceRequest = $serviceRequest;
    }

    /**
     * Send Request
     *
     * @param  array  $data
     *
     * @return mixed
     */
    public function send(array $data)
    {
        // Move to json nested key for Guzzle
        if (!isset($data['json'])) {
            $data['json'] = $data;
        }
        return $this->serviceRequest->send('AUTH_SERVICE', 'auth.system.registerTenantOwnerEndpoint', $data, true);
    }
}
