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

namespace Base\AppServivce\Repository;

use Base\AppServivce\Entity\AppInterface;

/**
 * App Repository Interface
 *
 * @package Base\AppServivce\Repository
 */
interface AppRepositoryInterface
{
    /**
     * Get App by App Id
     *
     * @param string $apId
     *
     * @return AppInterface|null
     */
    public function get(string $appId): ?AppInterface;

    /**
     * Add an App
     *
     * @param AppInterface $item
     *
     * @return string|null The inserted App Id
     */
    public function add(AppInterface $item): ?string;

    /**
     * Convert an array data from fetch assoc to Entity
     *
     * @param array|boolean $data
     *
     * @return AppInterface|null
     */
    public function convertToEntity($data): ?AppInterface;
}
