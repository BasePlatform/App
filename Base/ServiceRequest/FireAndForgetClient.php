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
use League\Uri\Schemes\Http as HttpUri;
use RuntimeException;
use InvalidArgumentException;

/**
 *
 * Fire a request to a service and return immediately
 *
 * Source: https://github.com/HipsterJazzbo/fire-and-forget/
 *
 * @package Base\ServiceRequest
 */
class FireAndForgetClient implements FireAndForgetClientInterface
{
    /**
     * Send Request to the Service
     *
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function request(string $uri, array $options = [])
    {
        try {
            $url = HttpUri::createFromString($uri);
        } catch (RuntimeException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
        $scheme = $url->getScheme() === 'https' ? 'ssl://' : '';
        $host   = $scheme . $url->getHost();
        $port   = $url->getPort() ?: $this->getDefaultPort($url->getScheme());
        $request = $this->getRequest($method, $url, $options);
        $socket  = @fsockopen($host, $port, $errno, $errstr, $this->connectionTimeout);
        if (! $socket) {
            throw new SocketException($errstr, $errno);
        }
        fwrite($socket, $request);
        fclose($socket);
    }

    /**
     * @param string  $method
     * @param HttpUri $url
     * @param array   $options
     *
     * @return string
     */
    private function getRequest(string $method, HttpUri $url, array $options = [])
    {
        // Prepare QueryString
        $queryString = http_build_query($options);
        // Prepare Headers
        $path = $method === 'GET' ? $url->getPath() . "?" . $queryString : $url->getPath();
        $headers = $method . " /" . $path . " HTTP/1.1\r\n";
        $headers .= "Host: " . $url->getHost() . "\r\n";
        $headers .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $headers .= "Content-Length: " . strlen($queryString) . "\r\n";
        $headers .= "Connection: Close\r\n";
        // Prepare Body
        $body = $method === 'GET' ? '' : $queryString;
        return $headers . "\r\n" . $body;
    }

    /**
     * Get default port from scheme such as https, http
     *
     * @param $scheme
     *
     * @return int
     */
    private function getDefaultPort($scheme)
    {
        switch ($scheme) {
            case 'https':
                $defaultPort = 443;
                break;
            case 'http':
                $defaultPort = 80;
                break;
            default:
                $defaultPort = 80;
        }
        return $defaultPort;
    }
}
