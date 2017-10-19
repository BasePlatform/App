<?php
/*
 * This file is part of the BasePlatform project.
 *
 * (c) BasePlatform project <https://github.com/BasePlatform>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Http;

/**
 * RequestFactory that provides a Request Instance in
 * PSR-7 Standard
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 */
class RequestFactory
{
  /**
   * Create a Request instance with PSR-7 Standard
   *
   * @return ServerRequest
   */
  public static function create()
  {
    return \Zend\Diactoros\ServerRequestFactory::fromGlobals();
  }
}