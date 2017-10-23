<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 409 error - Conflict Exception
 */
class ConflictException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Conflict Exception', $code = 409)
  {
    parent::__construct($message, $code);
  }
}
