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
