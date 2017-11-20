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

namespace Base\Model\ValueObject;

/**
 * Enum Value Object Interface
 *
 * @package Base\Model\ValueObject
 */
interface EnumValueObjectInterface extends ValueObjectInterface
{
    /**
     * Compare ordinal to other Enum object.
     *
     * @param EnumValueObject $other
     *
     * @return integer -1, 0, 1
     */
    public function compareTo(EnumValueObjectInterface $other): int;

    /**
     * Return value of the enum object.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Return name of the enum object.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Return ordinal cord.
     *
     * @return integer
     */
    public function getOrdinal(): int;

    /**
     * Validate value.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function validateValue($value): bool;
}
