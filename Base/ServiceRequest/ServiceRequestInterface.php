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
 * Service Request Interface
 *
 * @package Base\ServiceRequest
 */
interface ServiceRequestInterface
{
    /**
     * Send Request to the Service
     *
     * @param string $service
     * @param string $endpoint
     * @param array $options
     * @param array $wait - true = sync, false = async
     * @return mixed
     */
    public function send(string $service, string $endpoint, array $options = [], bool $wait = true);
}
