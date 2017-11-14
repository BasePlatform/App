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
use Base\Http\ResponseStatusCode;

/**
 * Represents an HTTP 405 error - Method Not Allowed
 *
 * @package Base\Exception
 */
class MethodNotAllowedException extends RuntimeException implements HttpExceptionInterface
{
    /**
     * @param string $message
     *
     * @param string|integer $code
     */
    public function __construct($message = 'Method Not Allowed', $code = ResponseStatusCode::HTTP_METHOD_NOT_ALLOWED)
    {
        parent::__construct($message, $code);
    }
}
