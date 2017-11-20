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

namespace Base\Middleware;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Return Response Time
 *
 * @package Base\Middleware
 */
class ResponseTimeMiddleware implements MiddlewareInterface
{
    /**
     * Attribute name in Header
     */
    const HEADER_ATTRIBUTE_NAME = 'X-Response-Time';

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $startTime =  defined('APP_START') ? APP_START : microtime(true);
        $response = $next->handle($request);
        return $response->withHeader(self::HEADER_ATTRIBUTE_NAME, sprintf('%2.3fms', (microtime(true) - $startTime) * 1000));
    }
}
