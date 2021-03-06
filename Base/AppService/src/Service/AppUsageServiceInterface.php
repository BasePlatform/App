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

namespace Base\AppService\Service;

use Base\AppService\Entity\AppUsageInterface;

/**
 * App Usage Service Interface
 *
 * @package Base\AppService\Service
 */
interface AppUsageServiceInterface
{
    /**
     * Activate the app
     *
     * @param  array  $data
     * @param  int    $trialDays
     * @return AppUsageInterface|null
     */
    public function activate(array $data, int $trialDays): ?AppUsageInterface;
}
