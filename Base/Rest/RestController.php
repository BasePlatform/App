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

namespace Base\Rest;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Base\Http\ResponseFactoryInterface;
use Base\Exception\MethodNotAllowedException;

/**
 * Abstract Rest Controller that provides common methods
 * for working with a Resource
 *
 * Structure suggestion from https://github.com/acelaya
 *
 * @package Base\Rest
 */
abstract class RestController implements MiddlewareInterface
{
  /**
   * Name of the ID field of the resource
   */
    const RESOURCE_ID = 'id';

  /**
   * @var ResponseFactoryInterface
   */
    public $responseFactory;

  /**
   * @param ResponseFactoryInterface $response
   */
    public function __construct(ResponseFactoryInterface $response)
    {
        $this->responseFactory = $response;
    }

  /**
   * {@inheritdoc}
   */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {

        $requestMethod = strtoupper($request->getMethod());
        $id = $request->getAttribute(static::RESOURCE_ID);
        switch ($requestMethod) {
            case 'GET':
                return isset($id)
            ? $this->get($request, $next)
            : $this->getList($request, $next);
            case 'POST':
                return $this->create($request, $next);
            case 'PUT':
                return $this->update($request, $next);
            case 'DELETE':
                return isset($id)
            ? $this->delete($request, $next)
            : $this->deleteList($request, $next);
            case 'HEAD':
                return $this->head($request, $next);
            case 'OPTIONS':
                return $this->options($request, $next);
            case 'PATCH':
                return $this->patch($request, $next);
            default:
                if ($next !== null) {
                    return $next->handle($request);
                }
                throw new MethodNotAllowedException();
        }
    }

  /**
   * Get by an Id
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function get(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Get List
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function getList(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Create
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function create(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Update
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function update(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Delete
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function delete(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Delete List
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function deleteList(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Head Request
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function head(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Options Request
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function options(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }

  /**
   * Patch Request
   *
   * @param ServerRequestInterface $request
   * @param RequestHandlerInterface $next
   *
   * @return null|ResponseInterface
   */
    public function patch(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }
}
