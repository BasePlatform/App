<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 405 error - Method Not Allowed
 */
class MethodNotAllowedException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Method Not Allowed', $code = 405)
  {
    parent::__construct($message, $code);
  }
}
