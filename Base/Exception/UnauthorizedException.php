<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 401 error - Unauthorized
 */
class UnauthorizedException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Unauthorized', $code = 401)
  {
    parent::__construct($message, $code);
  }
}
