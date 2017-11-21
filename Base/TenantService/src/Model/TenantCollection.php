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

namespace Base\TenantService\Model;

/**
 * Tenant Collection
 *
 * @package Base\TenantService\Model
 */
class TenantCollection implements TenantCollectionInterface
{
    use \Base\Model\Entity\EntityCollectionTrait;

    public function __construct(string $entityInterface = null)
    {
        $this->entityInterface = $entityInterface ?: \Base\TenantService\Model\Tenant::class;
    }
}
