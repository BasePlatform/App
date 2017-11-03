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
 * Represents a Not Active Tenant Status Exception
 *
 * @package Base\TenantService\Exception
 */
class NotActiveTenantException extends RuntimeException implements ServiceExceptionInterface
{
    use ServiceExceptionTrait;

  /**
   * @param string $message
   * @param bool $notification send notifcation or not
   * @param string $details
   * @param array $additionalData
   *
   * {@inheritdoc}
   */
    public function __construct(string $message = 'Tenant Is Not In Active Status', bool $notification = false, string $details = '', array $additionalData = [])
    {
        $this->message = $message;
        $this->statusCode = 403;
        $this->code = \Base\TenantService\Service::ERROR_CODE_SPACE+2;
        $this->details = $details;
        $this->additionalData = $additionalData;
        $this->notification = $notification;
    }

  /**
   * {@inheritdoc}
   */
    public function getReference(string $pathPrefix = ''): string
    {
        return $pathPrefix.'/api/problems/tenants/not-active-tenant';
    }
}
