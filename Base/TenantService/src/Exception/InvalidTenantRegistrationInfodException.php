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
 * Represents an Invalid Tenant Id Exception
 *
 * @package Base\Exception
 */
class InvalidTenantRegistrationInfodException extends RuntimeException implements ServiceExceptionInterface
{

  use ServiceExceptionTrait;

  /**
   * {@inheritdoc}
   */
  public function __construct(string $message = 'Invalid Tenant Registration Info', string $details = '', array $additionalData = [], bool $notification = false)
  {
    $this->message = $message;
    $this->statusCode = 400;
    $this->code = \Base\TenantService\Service::ERROR_CODE_SPACE+1;
    $this->details = $details;
    $this->additionalData = $additionalData;
    $this->notification = $notification;
  }

  /**
   * {@inheritdoc}
   */
  public function getReference(string $pathPrefix = ''): string
  {
    return $pathPrefix.'/api/problems/tenants/invalid-tenant-registration-info';
  }
}