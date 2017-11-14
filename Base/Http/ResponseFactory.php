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
use Base\Http\ResponseStatusCode;
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
    public function create(string $body = 'php://memory', int $status = ResponseStatusCode::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response($body, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function createEmpty(int $status = ResponseStatusCode::HTTP_NO_CONTENT, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\EmptyResponse($status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function createText(string $text, int $status = ResponseStatusCode::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\TextResponse($text, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function createHtml(string $html, int $status = ResponseStatusCode::HTTP_OK, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\HtmlResponse($html, $status, $headers);
    }

    /**
     * {@inheritdoc}
     */
    public function createJson($data, int $status = ResponseStatusCode::HTTP_OK, array $headers = [], int $encodingOptions = 79): ResponseInterface
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
        $statusCode = ResponseStatusCode::HTTP_INTERNAL_SERVER_ERROR;
        if (property_exists($e, 'statusCode') && !empty($e->getStatusCode())) {
            $statusCode = $e->getStatusCode();
        }
        return static::createJson($response, $statusCode);
    }

    /**
     * {@inheritdoc}
     */
    public function createRedirect(string $uri, int $status = ResponseStatusCode::HTTP_FOUND, array $headers = []): ResponseInterface
    {
        return new \Zend\Diactoros\Response\RedirectResponse($uri, $status, $headers);
    }
}
