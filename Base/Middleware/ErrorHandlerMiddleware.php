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
use Psr\Log\LoggerInterface;
use Base\Http\ResponseFactoryInterface;
use Base\Exception\HttpExceptionInterface;
use Base\Exception\ServiceExceptionInterface;
use Base\Exception\ServerErrorException;
use Error;
use RuntimeException;
use ErrorException;
use Exception;
use Throwable;

/**
 * ErrorHandler middleware - this middleware will catch all
 * ErrorException and produce a Response to the request if possible
 *
 * This class is implemented based on the suggestion of Zend Expressive Framework
 *
 * It also includes a default logger for logging error
 *
 * You can override the function of process() or handleThrowable() for
 * your own logic error handler
 *
 * @package Base\Middleware
 */
class ErrorHandlerMiddleware implements MiddlewareInterface
{
    /**
     * Log format for messages:
     *
     * STATUS [METHOD] path: message
     */
    const LOG_FORMAT = '%d [%s] %s: %s %s %s';

    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param LoggerInterface $logger
     *
     */
    public function __construct(ResponseFactoryInterface $responseFactory, LoggerInterface $logger = null)
    {
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $next): ResponseInterface
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if ((error_reporting() & $errno)) {
                // Error is not in mask
                // Throw ErrorException with special error_code
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });

        try {
            $response = $next->handle($request);
            if (!$response instanceof ResponseInterface) {
                throw new RuntimeException('Invalid Response');
            }
            return $response;
        } catch (Throwable $e) {
            $response = $this->handleThrowable($e, $request);
        } catch (Exception $e) {
            $response = $this->handleThrowable($e, $request);
        }
        restore_error_handler();
        // So we have an ErrorResponse - let's return it
        return $response;
    }

    /**
     * This function is turned to public function as it might be overrided
     * by application-based ErrorHandlerMiddleware
     *
     * Handles all throwables/exceptions, generating and returning a response.
     *
     *
     * @param Throwable|Exception $e
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handleThrowable($e, ServerRequestInterface $request): ResponseInterface
    {
        // Using a logger and Error is NOT an instance of HttpExceptionInterface // Then we log the error
        $logException = false;
        if (!($e instanceof HttpExceptionInterface) && !($e instanceof ServiceExceptionInterface)) {
            $logException = true;
        } elseif ($e instanceof ServiceExceptionInterface && $e->getNotification() == true) {
            $logException = true;
        }
        if ($this->logger && $logException) {
            $this->logger->error(sprintf(
                self::LOG_FORMAT,
                $e->getCode(),
                $request->getMethod(),
                (string) $request->getUri(),
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            ));
        }

        // Handle to hide the message if needed
        // Consider the ENV dev, etc.
        // Currently, it wont't show the real value $message if $e is
        // an instance of Error - Check log at error_log or logger
        $debug = env('APP_DEBUG', false);
        if (!$debug) {
            if (($e instanceof Error) ||
               ($e instanceof ErrorException) ||
               ($e instanceof ServerErrorException)) {
                if ($e instanceof ServerErrorException) {
                    $e = new ServerErrorException($e->getMessage(), $e->getNotification(), null, null);
                } else {
                    $e = new Exception('Internal Server Error', 500);
                }
            }
        } else {
            if ($e instanceof Error) {
                $e = new Exception('Internal Server Error', 500);
            }
        }
        return $this->responseFactory->createError($e, $request);
    }
}
