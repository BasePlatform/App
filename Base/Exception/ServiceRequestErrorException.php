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
 * Represents a Service Request Communication Error from Service Exception
 *
 * @package Base\Exception
 */
class ServiceRequestErrorException extends RuntimeException implements ServiceExceptionInterface
{

    use ServiceExceptionTrait;

    /**
     * @param string $message
     * @param bool $notification send notifcation or not
     * @param string $details
     * @param array $additionalData
     *
     */
    public function __construct(string $message = 'Service Communication Error', bool $notification = false, string $details = null, array $additionalData = null)
    {
        $this->message = $message;
        $this->statusCode = ResponseStatusCode::HTTP_INTERNAL_SERVER_ERROR;
        $this->code = 0;
        $this->notification = $notification;
        $this->details = $details;
        $this->additionalData = $additionalData;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference(string $pathPrefix = ''): string
    {
        return $pathPrefix.'/api/problems/service-request-error';
    }
}
