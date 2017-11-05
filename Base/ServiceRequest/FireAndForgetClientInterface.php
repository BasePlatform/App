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

namespace Base\ServiceRequest;

/**
 *
 * Fire a request to a service and return immediately
 *
 * @package Base\ServiceRequest
 */
interface FireAndForgetClientInterface
{
    /**
     * Send Request to the Service
     *
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    public function request(string $uri, array $options = []);
}
