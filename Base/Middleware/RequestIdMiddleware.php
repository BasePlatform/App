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
use Ramsey\Uuid\Uuid;

/**
 * Create and add UUID for each request
 *
 * @package Base\Middleware
 */
class RequestIdMiddleware implements MiddlewareInterface
{
    /**
     * Attribute name in Header
     */
    const HEADER_ATTRIBUTE_NAME = 'X-Request-Id';

    /**
     * Attribute name in Request
     */
    const REQUEST_ATTRIBUTE_NAME = 'request-id';

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $requestId = $request->getHeaderLine(self::HEADER_ATTRIBUTE_NAME);
        if (empty($requestId)) {
            $uuid = Uuid::uuid4()->toString();
            $request = $request->withAttribute(self::REQUEST_ATTRIBUTE_NAME, $uuid);
            $response = $next->handle($request);
            return $response->withHeader(self::HEADER_ATTRIBUTE_NAME, $uuid);
        } else {
            return $next->handle($request);
        }
    }
}
