<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 500 error - Internal Server Error
 */
class InternalServerErrorException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Internal Server Error', $code = 500)
  {
    parent::__construct($message, $code);
  }
}
