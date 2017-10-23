<?php

namespace Base\Exception;

/**
 * The trait that provides the common methods of a ServiceException defined by ServiceExceptionInterface
 */
trait ServiceExceptionTrait
{
  /**
   * @var int
   */
  private $statusCode;

  /**
   * @var string
   */
  private $details;

  /**
   * @var array
   */
  private $additionalData = [];

  /**
   * @var boolean
   */
  private $notification = false;

  /**
   * Return Status Code
   *
   * @return int
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**
   * Return Exception Details
   *
   * @return string
   */
  public function getDetails()
  {
    return $this->details;
  }

  /**
   * Return Exception Additional Data
   *
   * @return array
   */
  public function getAdditionalData()
  {
    return $this->additionalData;
  }

  /**
   * Return Notification
   *
   * @return boolean
   */
  public function getNotification()
  {
    return $this->notification;
  }
}