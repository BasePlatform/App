<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 400 error - Bad Request
 */
class BadRequestException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Bad Request', $code = 400)
  {
    parent::__construct($message, $code);
  }
}
