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
 * Represents an Existed Tenant Exception
 *
 * @package Base\TenantService\Exception
 */
class ExistedTenantException extends RuntimeException implements ServiceExceptionInterface
{
    use ServiceExceptionTrait;

    /**
     * @param string $message
     * @param bool $notification send notifcation or not
     * @param string $details
     * @param array $additionalData
     *
     */
    public function __construct(string $message = 'Tenant Is Already Existed', bool $notification = false, string $details = null, array $additionalData = null)
    {
        $this->message = $message;
        $this->statusCode = 403;
        $this->code = TENANT_SERVICE['ERROR_CODE_SPACE']+2;
        $this->notification = $notification;
        $this->details = $details;
        $this->additionalData = $additionalData;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference(string $pathPrefix = ''): string
    {
        return $pathPrefix.'/api/problems/tenants/existed-tenant';
    }
}
