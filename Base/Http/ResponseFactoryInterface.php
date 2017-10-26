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
 * ResponseFactoryInterface that provides a Response Factory Interface
 * PSR-7 Standard
 *
 * @package Base\Http
 */
interface ResponseFactoryInterface
{

  const DEFAULT_JSON_FLAGS = 79;

  /**
   * Create a standard PSR-7 Response
   *
   * @param string $body
   * @param int $status
   * @param array $headers
   *
   * @return ResponseInterface
   */
  public function create(string $body = 'php://memory', int $status = 200, array $headers = []): ResponseInterface;

  /**
   * Create an Empty Response
   *
   * @param int $status
   * @param array $headers
   *
   * @return ResponseInterface
   */
  public function createEmpty(int $status = 204, array $headers = []): ResponseInterface;

  /**
   * Create a Text Response
   *
   * @param string $text
   * @param int $status
   * @param array $headers
   *
   * @return ResponseInterface
   */
  public function createText(string $text, int $status = 200, array $headers = []): ResponseInterface;

  /**
   * Create an Html Response
   *
   * @param string $html
   * @param int $status
   * @param array $headers
   *
   * @return ResponseInterface
   */
  public function createHtml(string $html, int $status = 200, array $headers = []): ResponseInterface;

  /**
   * Create a Json Response
   *
   * @param array $data
   * @param int $status
   * @param array $headers
   * @param int $encodingOptions
   *
   * @return ResponseInterface
   */
  public function createJson(array $data, int $status = 200, array $headers = [], int $encodingOptions = self::DEFAULT_JSON_FLAGS): ResponseInterface;

  /**
   * Create an Error Response
   *
   * @param Exception $e
   * @param ServerRequestInterface $request
   *
   * @return ResponseInterface
   */
  public function createError(Exception $e, ServerRequestInterface $request): ResponseInterface;

  /**
   * Create a Redirect Response
   *
   * @param string $uri
   * @param int $status
   * @param array $headers
   *
   * @return ResponseInterface
   */
  public function createRedirect(string $uri, int $status = 302, array $headers = []): ResponseInterface;
}