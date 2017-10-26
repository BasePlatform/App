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

namespace Base\Middleware;

use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Base\Exception\BadRequestException;

/**
 * Body Parser Middleware
 *
 * Currently support 2 strategies: Json Body Parse, Form Url Encoded
 *
 * @package Base\Middleware
 */
class BodyParserMiddleware implements MiddlewareInterface
{
  /**
   * @var string[]
   */
  protected $methods = ['POST', 'PUT', 'PATCH', 'DELETE', 'COPY', 'LOCK', 'UNLOCK'];

  /**
   * Strategies and their allowed header content type
   *
   * @var string[]
   */
  private $contentTypes = [
    // strategy => header content type
    'json' => ['application/json'],
    'urlencoded' => ['application/x-www-form-urlencoded']
  ];

  /**
   * Body Parse Strategy
   *
   * @var string
   */
  private $strategy;

  /**
   * Override parsed body or not
   *
   * @var bool
   */
  private $overrideParsedBody;

  /**
   * Parse Options
   *
   * @var array
   */
  private $options;

  /**
   * @param string $strategy
   * @param bool $overrideParsedBody
   * @param array $options
   */
  public function __construct(string $strategy = 'json', bool $overrideParsedBody = false, array $options = [])
  {
    $this->strategy = $strategy;
    $this->overrideParsedBody = $overrideParsedBody;
    $this->options = $options;
  }

  /**
   * {@inheritdoc}
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
  {
    if ($this->checkRequestAndStrategy($request)) {
      $rawBody = trim((string) $request->getBody());
      $parsedBody = [];
      if (!empty($rawBody)) {
        // Passed Checking
        switch ($this->strategy) {
          case 'json':
            $assoc = isset($this->options['assoc']) ? (bool) $this->options['assoc'] : true;
            $depth = isset($this->options['depth']) ? (int) $this->options['depth'] : 512;
            $options = isset($this->options['options']) ? (int) $this->options['options'] : 0;
            $parsedBody = json_decode($rawBody, $assoc, $depth, $options);
            if (json_last_error() !== JSON_ERROR_NONE) {
              throw new BadRequestException(sprintf(
                'Error Parsing JSON Request Body: %s',
                json_last_error_msg()));
            }
            break;
          case 'urlencoded':
            parse_str($rawBody, $parsedBody);
            break;
          default:
            break;
        }
      }
      return $next->handle($request->withParsedBody($parsedBody));
    } else {
      return $next->handle($request);
    }
  }

  /**
   * Check whether the request payload need to be processed based on the strategy
   *
   * @param ServerRequestInterface $request
   *
   * @return bool
   */
  private function checkRequestAndStrategy(ServerRequestInterface $request)
  {
    // Check body has been parsed or not
    $parsedBody = $request->getParsedBody();
    if (!empty($parsedBody) && !$this->overrideParsedBody) {
      return false;
    }
    if (!in_array($request->getMethod(), $this->methods, true)) {
      return false;
    }
    if (isset($this->contentTypes[$this->strategy])) {
      $contentType = $request->getHeaderLine('Content-Type');
      foreach ($this->contentTypes[$this->strategy] as $allowedType) {
        if (stripos($contentType, $allowedType) === 0) {
          return true;
        }
      }
      return false;
    } else {
      return false;
    }
  }
}
