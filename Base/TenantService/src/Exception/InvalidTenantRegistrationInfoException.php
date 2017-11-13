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

namespace Base\TenantService\Exception;

use RuntimeException;
use Base\Exception\ServiceExceptionInterface;
use Base\Exception\ServiceExceptionTrait;

/**
 * Represents an Invalid Tenant Registration Info Exception
 *
 * @package Base\TenantService\Exception
 */
class InvalidTenantRegistrationInfoException extends RuntimeException implements ServiceExceptionInterface
{
    use ServiceExceptionTrait;

    /**
     * @param string $message
     * @param bool $notification send notifcation or not
     * @param string $details
     * @param array $additionalData
     *
     */
    public function __construct(string $message = 'Invalid Tenant Registration Info', bool $notification = false, string $details = null, array $additionalData = null)
    {
        $this->message = $message;
        $this->statusCode = 422;
        $this->code = TENANT_SERVICE_CONSTANTS['ERROR_CODE_SPACE']+1;
        $this->notification = $notification;
        $this->details = $details;
        $this->additionalData = $additionalData;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference(string $pathPrefix = ''): string
    {
        return $pathPrefix.'/api/problems/tenants/invalid-tenant-registration-info';
    }
}
