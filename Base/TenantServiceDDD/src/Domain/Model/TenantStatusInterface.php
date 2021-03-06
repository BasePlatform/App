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

use Base\Model\ValueObject\EnumValueObjectInterface;

/**
 * Tenant Status Value Object Interface
 *
 * @package Base\TenantService\Domain\Model
 */
interface TenantStatusInterface extends EnumValueObjectInterface
{
}
