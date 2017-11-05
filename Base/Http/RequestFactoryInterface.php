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

/**
 * Interface for RequestFactory
 *
 * @package Base\Http
 */
interface RequestFactoryInterface
{
    /**
     * Create a Request instance with PSR-7 Standard
     *
     * @return ServerRequest
     */
    public static function create(): ServerRequestInterface;
}
