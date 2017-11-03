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
use Base\Exception\BadRequestException;
use Ramsey\Uuid\Uuid;

/**
 * Create and add UUID for each request
 *
 * @package Base\Middleware
 */
class RequestIdMiddleware implements MiddlewareInterface
{
  /**
   * Attribute name in Response Header
   */
    const RESPONSE_HEADER_ATTRIBUTE_NAME = 'X-Request-Id';

  /**
   * Attribute name in Request Header
   */
    const REQUEST_ATTRIBUTE_NAME = 'request-id';

  /**
   * {@inheritdoc}
   */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        $requestId = $request->getAttribute(self::REQUEST_ATTRIBUTE_NAME);
        if (empty($requestId)) {
            $uuid = Uuid::uuid4()->toString();
            $request = $request->withAttribute(self::REQUEST_ATTRIBUTE_NAME, $uuid);
            $response = $next->handle($request);
            return $response->withHeader(self::RESPONSE_HEADER_ATTRIBUTE_NAME, $uuid);
        } else {
            return $next->handle($request);
        }
    }
}
