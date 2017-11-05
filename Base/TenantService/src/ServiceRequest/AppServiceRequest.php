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

namespace Base\TenantService\ServiceRequest;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\ClientInterface;

/**
 * App Service Request
 *
 * Send a request to other appService
 *
 * @package Base\TenantService\ServiceRequest
 */
class AppServiceRequest implements ServiceRequestInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var array
     */
    private $endpoints;

    /**
     * @param ClientInterface $factory
     */
    public function __construct(string $baseUri, array $endpoints, ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param FactoryInterface $factory
     * @param FactoryInterface $variantFactory
     */
    public function send(string $endpoint, array $options = null, bool $wait = true)
    {
        $this->httpClient = null;
    }
}
