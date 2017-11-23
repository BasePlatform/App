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

namespace Base\TenantService\Domain\Exception;

use RuntimeException;
use Base\Exception\ServiceExceptionInterface;
use Base\Exception\ServiceExceptionTrait;
use Base\Http\ResponseStatusCode;

/**
 * Represents an Invalid TenantId Value
 *
 * @package Base\TenantService\Domain\Exception
 */
class InvalidTenantIdException extends RuntimeException implements ServiceExceptionInterface
{
    use ServiceExceptionTrait;

    /**
     * @param string $message
     * @param bool $notification send notifcation or not
     * @param string $details
     * @param array $additionalData
     *
     */
    public function __construct(
        string $message = 'Invalid TenantId Value',
        bool $notification = false,
        string $details = null,
        array $additionalData = null
    ) {
        $this->message = $message;
        $this->statusCode = ResponseStatusCode::HTTP_UNPROCESSABLE_ENTITY;
        $this->code = TENANT_SERVICE_CONSTANTS['ERROR_CODE_SPACE']+3;
        $this->notification = $notification;
        $this->details = $details;
        $this->additionalData = $additionalData;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference(string $pathPrefix = null): string
    {
        $pathPrefix = $pathPrefix ?: '';
        return $pathPrefix.'/api/problems/tenants/invalid-tenantid';
    }
}
