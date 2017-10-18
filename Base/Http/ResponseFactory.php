<?php

namespace App\Base\Factory;

class ResponseFactory
{
  /**
   * Create a Response Instance with PSR-7
   *
   * @param String $vendor
   *
   * @return ServerRequest
   */
  public static function create($type, $vendor = null)
  {

    switch ($type) {
      default:
        return new \Zend\Diactoros\Response\ServerResponseFactory::fromGlobals();
        break;
    }
  }
}