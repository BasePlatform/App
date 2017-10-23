<?php

namespace Base\Exception;

/**
 * The interface for the detail-oriented exceptions within a specific service
 *
 */
interface ServiceExceptionInterface
{
  /**
   * Create a Service Exception
   *
   * @param string $message
   * @param string $details
   * @param array $additionalData
   * @param bool $notification
   *
   * @return ServiceExceptionInterface
   */
  public static function create(string $message, string $details = null, array $additionalData = null, bool $notification = false) : ServiceExceptionInterface;

  /**
   * Return Exception Reference URL
   *
   * @return string
   */
  public function getReference(string $path = '');

  /**
   * Return Status Code
   *
   * @return int
   */
  public function getStatusCode();

  /**
   * Return Exception Details
   *
   * @return string
   */
  public function getDetails();

  /**
   * Return Exception Additional Data
   *
   * @return array
   */
  public function getAdditionalData();

  /**
   * Notify the exception to
   *
   * @return boolean
   */
  public function getNotification();
}