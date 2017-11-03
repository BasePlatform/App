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
   * {@inheritdoc}
   */
    public function create(string $body = 'php://memory', int $status = 200, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response($body, $status, $headers);
    }

  /**
   * {@inheritdoc}
   */
    public function createEmpty(int $status = 204, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\EmptyResponse($status, $headers);
    }

  /**
   * {@inheritdoc}
   */
    public function createText(string $text, int $status = 200, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\TextResponse($text, $status, $headers);
    }

  /**
   * {@inheritdoc}
   */
    public function createHtml(string $html, int $status = 200, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\HtmlResponse($html, $status, $headers);
    }

  /**
   * {@inheritdoc}
   */
    public function createJson(array $data, int $status = 200, array $headers = [], int $encodingOptions = 79): ResponseInterface
    {
        return new \Zend\Diactoros\Response\JsonResponse($data, $status, $headers, $encodingOptions);
    }

  /**
   * {@inheritdoc}
   */
    public function createError(Exception $e, ServerRequestInterface $request): ResponseInterface
    {
        $response = [
        'code' => $e->getCode(),
        'message' => $e->getMessage()
        ];
        if (property_exists($e, 'reference') && !empty($e->getReference())) {
            $response['reference'] = $e->getReference();
        }
        if (property_exists($e, 'details') && !empty($e->getDetails())) {
            $response['details'] = $e->getDetails();
        }
        if (property_exists($e, 'additionalData') && !empty($e->getAdditionalData())) {
            $response['additionalData'] = $e->getAdditionalData();
        }
        return static::createJson($response, 500);
    }

  /**
   * {@inheritdoc}
   */
    public function createRedirect(string $uri, int $status = 302, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\RedirectResponse($uri, $status, $headers);
    }
}
