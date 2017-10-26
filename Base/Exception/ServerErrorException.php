<?php
/*
 * This file is part of the BasePlatform project.
 *
 * @link https://github.com/BasePlatform
 * @license https://github.com/BasePlatform/Base/blob/master/LICENSE.txt
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Exception;

use RuntimeException;

/**
 * Represents a Server Error from Service Exception
 *
 * Use this class for adding additional information to error response
 *
 * @package Base\Exception
 */
class ServerErrorException extends RuntimeException implements ServiceExceptionInterface
{

  use ServiceExceptionTrait;

  /**
   * {@inheritdoc}
   */
  public static function create(string $message, string $details = null, array $additionalData = null, bool $notification = false): ServiceExceptionInterface
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
  public function getReference(string $path = ''): string
  {
    return $url.'/api/problems/server-error';
  }
}