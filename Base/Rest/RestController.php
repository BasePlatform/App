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
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
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
            ? $this->getAction($request, $next)
            : $this->getListAction($request, $next);
            case 'POST':
                return $this->createAction($request, $next);
            case 'PUT':
                return $this->updateAction($request, $next);
            case 'DELETE':
                return isset($id)
            ? $this->deleteAction($request, $next)
            : $this->deleteListAction($request, $next);
            case 'HEAD':
                return $this->headAction($request, $next);
            case 'OPTIONS':
                return $this->optionsAction($request, $next);
            case 'PATCH':
                return $this->patchAction($request, $next);
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
    public function getAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function getListAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function createAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function updateAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function deleteAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function deleteListAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function headAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function optionsAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
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
    public function patchAction(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        throw new MethodNotAllowedException();
    }
}
