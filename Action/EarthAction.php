<?php

namespace App\Action;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Base\Http\ResponseFactoryInterface;

class EarthAction implements MiddlewareInterface
{
  /**
   * @var ResponseFactoryInterface
   */
  private $responseFactory;

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
  public function process(ServerRequestInterface $request, RequestHandlerInterface $next)
  {
    return $this->responseFactory->createJson(['ack' => time()]);
  }
}
