<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents an HTTP 422 error - Unprocessable Entity
 */
class UnprocessableEntityException extends RuntimeException implements HttpExceptionInterface
{
  /**
   * @param string $message
   *
   * @param string|integer $code
   */
  public function __construct($message = 'Unprocessable Entity', $code = 422)
  {
    parent::__construct($message, $code);
  }
}
