<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 403 error - Forbidden Exception
 */
class ForbiddenException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Forbidden', $code = 403)
  {
    parent::__construct($message, $code);
  }
}
