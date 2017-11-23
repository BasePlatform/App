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

namespace Base\TenantService\Domain\Model;

/**
 * Tenant Status Value Object
 *
 * @package Base\TenantService\Domain\Model
 */
class TenantStatus implements TenantStatusInterface
{
    use \Base\Model\ValueObject\EnumValueObjectTrait;

    // Tenant is Active
    const STATUS_ACTIVE = 'active';

    // Tenant is Disabled
    const STATUS_DISABLED = 'disabled';
}
