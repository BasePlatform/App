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

namespace Base\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * ResponseFactoryInterface that provides a Response Factory Interface
 * PSR-7 Standard
 */
interface ResponseFactoryInterface
{

  const DEFAULT_JSON_FLAGS = 79;

  /**
   * Create a standard PSR-7 Response
   *
   */
  public function create($body = 'php://memory', $status = 200, array $headers = []);

  /**
   * Create an Empty Response
   *
   * {@inheritdoc}
   */
  public function createEmpty($status = 204, array $headers = []);

  /**
   * Create a Text Response
   *
   * {@inheritdoc}
   */
  public function createText($text, $status = 200, array $headers = []);

  /**
   * Create an Html Response
   *
   * {@inheritdoc}
   */
  public function createHtml($html, $status = 200, array $headers = []);

  /**
   * Create a Json Response
   *
   * {@inheritdoc}
   */
  public function createJson($data, $status = 200, array $headers = [], $encodingOptions = self::DEFAULT_JSON_FLAGS);

  /**
   * Create an Error Response
   *
   * {@inheritdoc}
   */
  public function createError($e, ServerRequestInterface $request);

  /**
   * Create a Redirect Response
   *
   * {@inheritdoc}
   */
  public function createRedirect($uri, $status = 302, array $headers = []);
}