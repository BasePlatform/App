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

namespace Base\ServiceRequest;

use GuzzleHttp\RequestOptions;
use GuzzleHttp\ClientInterface;
use Base\Exception\ServiceRequestErrorException;
use InvalidArgumentException;

/**
 * Service Request
 *
 * Send a request to other microservice
 *
 * @package Base\ServiceRequest
 */
class ServiceRequest implements ServiceRequestInterface
{
    /**
     * @var array
     */
    private $endpoints;

    /**
     * @var array
     */
    private $options;

    /**
     * @param array $endpoints
     * @param array $options
     * @param array $httpClient
     */
    public function __construct(array $endpoints = [], array $options = [])
    {
        $this->endpoints = $endpoints;
        if (empty($options)) {
            $this->options = [
              RequestOptions::CONNECT_TIMEOUT => env('SERVICE_CONNECT_TIMEOUT', 3),
              RequestOptions::HTTP_ERRORS => false,
              RequestOptions::TIMEOUT => env('SERVICE_TIMEOUT', 5),
            ];
        } else {
            $this->options = $options;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function send(string $service, string $endpoint, array $options = [], bool $wait = true, bool $sendAsync = false)
    {
        if (empty($service)) {
            throw new InvalidArgumentException('Missing Service In Service Request');
        }
        if (empty($endpoint)) {
            throw new InvalidArgumentException('Missing Endpoint In Service Request');
        }
        $endpoints = $this->endpoints;
        // Check not found endpoint in service
        if (isset($endpoints[$service]) && isset($endpoints[$service][$endpoint])) {
            // Passed all, move
            $endpointMethod = $endpoints[$service][$endpoint]['method'] ?? null;
            if (!$endpointMethod) {
                throw new InvalidArgumentException('Invalid Endpoint Method In Service Request');
            }

            $serviceURL = defined($service.'_URL') ? constant($service.'_URL') : SERVICE_DEFAULT_URL;
            $endpointPath = $endpoints[$service][$endpoint]['path'] ?? '';

            $endpointOptions = $endpoints[$service][$endpoint]['options'] ?? [];
            $options = array_merge($this->options, $endpointOptions, $options);

            $method = 'request';

            if ($wait) {
                $client = new \GuzzleHttp\Client($this->options);
                if ($sendAsync) {
                    $method = 'requestAsync';
                }
            } else {
                $client = new FireAndForgetClient();
                // If we have json data
                // We only want that content for FireAndForgetClient Request
                if (isset($options['json'])) {
                    $options = $options['json'];
                }
            }
            try {
                $result = $client->{$method}(
                    $endpointMethod,
                    $serviceURL.$endpointPath,
                    $options
                );
                return $sendAsync ? $result->wait() : $result;
            } catch (\Exception $e) {
                throw new ServiceRequestErrorException('Service Communication Error', true, $e->getMessage());
            }
        } else {
            throw new InvalidArgumentException('Invalid Endpoint `'.$endpoint.'` In Service `'.$service.'` Request');
        }
    }
}
