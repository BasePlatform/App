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
 * Represents an HTTP 422 error - Unprocessable Entity
 *
 * @package Base\Exception
 */
class UnprocessableEntityException extends RuntimeException implements HttpExceptionInterface
{
    /**
     * @param string $message
     *
     * @param string|integer $code
     */
    public function __construct($message = 'Unprocessable Entity', $code = ResponseStatusCode::HTTP_UNPROCESSABLE_ENTITY)
    {
        parent::__construct($message, $code);
    }
}
