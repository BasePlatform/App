<?php
/*
 * This file is part of the BasePlatform project.
 *
 * (c) BasePlatform project <https://github.com/BasePlatform>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Base\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * ResponseFactory that provides a Response Instance in
 * PSR-7 Standard based on Zend\Diactoros package
 *
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 */
class ResponseFactory implements ResponseFactoryInterface
{
  /**
   * Create a standard PSR-7 Response
   *
   * {@inheritdoc}
   */
   public function create($body = 'php://memory', $status = 200, array $headers = [])
   {
      return new \Zend\Diactoros\Response($body, $status, $headers);
   }

  /**
   * Create an Empty Response
   *
   * {@inheritdoc}
   */
  public function createEmpty($status = 204, array $headers = [])
  {
    return new \Zend\Diactoros\Response\EmptyResponse($status, $headers);
  }

  /**
   * Create a Text Response
   *
   * {@inheritdoc}
   */
  public function createText($text, $status = 200, array $headers = [])
  {
    return new \Zend\Diactoros\Response\TextResponse($text, $status, $headers);
  }

  /**
   * Create an Html Response
   *
   * {@inheritdoc}
   */
  public function createHtml($html, $status = 200, array $headers = [])
  {
    return new \Zend\Diactoros\Response\HtmlResponse($html, $status, $headers);
  }

  /**
   * Create a Json Response
   *
   * {@inheritdoc}
   */
  public function createJson($data, $status = 200, array $headers = [], $encodingOptions = self::DEFAULT_JSON_FLAGS)
  {
    return new \Zend\Diactoros\Response\JsonResponse($data, $status, $headers, $encodingOptions);
  }

  /**
   * Create an Error Response
   *
   * {@inheritdoc}
   */
  public function createError($e, ServerRequestInterface $request)
  {
    $response = [
      'code' => $e->getCode(),
      'message' => $e->getMessage()
    ];
    if (property_exists($e, 'reference')) {
      $response['reference'] = $e->getReference();
    }
    if (property_exists($e, 'details')) {
      $response['details'] = $e->getDetails();
    }
    if (property_exists($e, 'additionalData')) {
      $response['additionalData'] = $e->getAdditionalData();
    }
    return new \Zend\Diactoros\Response\JsonResponse($response
      , 500);
  }

  /**
   * Create a Redirect Response
   *
   * {@inheritdoc}
   */
  public function createRedirect($uri, $status = 302, array $headers = [])
  {
    return new \Zend\Diactoros\Response\RedirectResponse($uri, $status, $headers);
  }
}