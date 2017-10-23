<?php

namespace Base\Exception;

use RuntimeException;

/**
 * Represents a Server Error from Service Exception
 */
class ServerErrorException extends RuntimeException implements ServiceExceptionInterface
{

  use ServiceExceptionTrait;

  /**
   * {@inheritdoc}
   */
  public static function create(string $message, string $details = null, array $additionalData = null, bool $notification = false) : ServiceExceptionInterface
  {
    $e = new self($message, 500);
    $e->statusCode = 500;
    $e->details = $details;
    $e->additionalData = $additionalData;
    $e->notification = $notification;
    return $e;
  }

  /**
   * {@inheritdoc}
   */
  public function getReference(string $path = '')
  {
    return $url.'/api/problems/server-error';
  }
}