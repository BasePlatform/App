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

declare(strict_types=1);

namespace Base\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Exception;

/**
 * ResponseFactory that provides a Response Instance in
 * PSR-7 Standard based on Zend\Diactoros package
 *
 * @package Base\Http
 */
class ResponseFactory implements ResponseFactoryInterface
{
  /**
   * Create a standard PSR-7 Response
   *
   * {@inheritdoc}
   */
   public function create(string $body = 'php://memory', int $status = 200, array $headers = []): ResponseInterface
   {
      return new \Zend\Diactoros\Response($body, $status, $headers);
   }

  /**
   * Create an Empty Response
   *
   * {@inheritdoc}
   */
  public function createEmpty(int $status = 204, array $headers = []): ResponseInterface
  {
    return new \Zend\Diactoros\Response\EmptyResponse($status, $headers);
  }

  /**
   * Create a Text Response
   *
   * {@inheritdoc}
   */
  public function createText(string $text, int $status = 200, array $headers = []): ResponseInterface
  {
    return new \Zend\Diactoros\Response\TextResponse($text, $status, $headers);
  }

  /**
   * Create an Html Response
   *
   * {@inheritdoc}
   */
  public function createHtml(string $html, int $status = 200, array $headers = []): ResponseInterface
  {
    return new \Zend\Diactoros\Response\HtmlResponse($html, $status, $headers);
  }

  /**
   * Create a Json Response
   *
   * {@inheritdoc}
   */
  public function createJson(array $data, int $status = 200, array $headers = [], int $encodingOptions = self::DEFAULT_JSON_FLAGS): ResponseInterface
  {
    return new \Zend\Diactoros\Response\JsonResponse($data, $status, $headers, $encodingOptions);
  }

  /**
   * Create an Error Response
   *
   * {@inheritdoc}
   */
  public function createError(Exception $e, ServerRequestInterface $request): ResponseInterface
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
    return static::createJson($response
      , 500);
  }

  /**
   * Create a Redirect Response
   *
   * {@inheritdoc}
   */
  public function createRedirect(string $uri, int $status = 302, array $headers = []): ResponseInterface
  {
    return new \Zend\Diactoros\Response\RedirectResponse($uri, $status, $headers);
  }
}