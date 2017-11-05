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
 * RequestFactory that provides a Request Instance follows
 * PSR-7 Standard
 *
 * @package Base\Http
 */
class RequestFactory implements RequestFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public static function create(): ServerRequestInterface
    {
        return \Zend\Diactoros\ServerRequestFactory::fromGlobals();
    }
}
