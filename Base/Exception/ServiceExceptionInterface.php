<?php
/*
 * This file is part of the BasePlatform project.
 *
 * (c) BasePlatform project <https://github.com/BasePlatform>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Exception;

/**
 * The interface for the detail-oriented exceptions within a specific service
 *
 * @package Base\Exception
 */
interface ServiceExceptionInterface
{
  /**
   * Return Exception Reference URL
   *
   * @return string
   */
  public function getReference(string $pathPrefix = ''): string;

  /**
   * Return Status Code
   *
   * @return int
   */
  public function getStatusCode(): int;

  /**
   * Return Exception Details
   *
   * @return string
   */
  public function getDetails(): string;

  /**
   * Return Exception Additional Data
   *
   * @return array
   */
  public function getAdditionalData(): array;

  /**
   * Notify the exception to
   *
   * @return boolean
   */
  public function getNotification(): bool;
}