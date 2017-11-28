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

use Base\Domain\Exception\InvalidTenantIdException;
use Ramsey\Uuid\Uuid;

/**
 * TenantId Value Object
 *
 * @package Base\TenantService\Domain\Model
 */
class TenantId implements TenantIdInterface
{
    // Min Length of the TenantId
    const ID_MIN_LENGTH = 3;

    // Max Length of the TenantId
    const ID_MAX_LENGTH = 128;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($this->validate($value)) {
            $this->value = $value;
        }
        throw new InvalidTenantIdException();
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromNameDomain(string $name = null, string $domain = null): TenantIdInterface
    {
        $domain = $domain ?: '';
        if (!empty($name)) {
            return new self($name.$domain);
        } else {
            $uuid = Uuid::uuid4()->toString();
            return new self($uuid.$domain);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate(string $value): bool
    {
        // Check for not empty, non-unicode characters and length
        if (!empty($value) && mb_check_encoding($value, 'ASCII') && strlen($value) >= self::MIN_LENGTH && strlen($value) <= self::MAX_LENGTH) {
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function equals(TenantIdInterface $other): bool
    {
        return $this->toString() === $other->toString();
    }
}
