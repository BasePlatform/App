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

namespace Base\Common\ValueObject;

use Ramsey\Uuid\Uuid;

/**
 * TenantId Value Object
 *
 * @package Base\Common\ValueObject
 */
class TenantId implements TenantIdInterface
{
    const MIN_LENGTH = 3;

    const MAX_LENGTH = 128;

    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    public function __construct(string $value = null)
    {
        if ($this->validate($value)) {
            $this->value = $value;
        } else {
            $this->value = null;
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
    public static function createFromString(string $name): TenantIdInterface
    {
        return new self($name);
    }

    /**
     * {@inheritdoc}
     */
    public static function createFromStringNameDomain(string $name = '', string $domain = ''): TenantIdInterface
    {
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
    public function setValue(string $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): ?string
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): ?string
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
