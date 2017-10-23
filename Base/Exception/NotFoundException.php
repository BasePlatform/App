<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 404 error - Not Found
 */
class NotFoundException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Not Found', $code = 404)
  {
    parent::__construct($message, $code);
  }
}
