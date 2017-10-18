<?php

namespace App\Action;

use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;

class MarsAction implements RequestHandlerInterface
{
  /**
   * Handle the request and return a response.
   *
   * @param ServerRequestInterface $request
   *
   * @return ResponseInterface
   */
  public function handle(ServerRequestInterface $request) {
    echo 'Mars!';
  }
}

