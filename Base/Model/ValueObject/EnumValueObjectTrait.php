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

namespace Base\Model\ValueObject;

/**
 * Enum Value Object Trait
 *
 * Original Source: https://github.com/satooshi/ValueObject
 *
 * @package Base\Model\ValueObject
 */
trait EnumValueObjectTrait
{
    /**
     * @var mixed
     */
    private $value;

    /**
     * Enum list.
     *
     * @var array
     */
    private static $options;

    /**
     * Private constructor
     *
     * @param mixed $value
     */
    final private function __construct($value)
    {
        if ($this->validateValue($value)) {
            $this->value = $value;
        }
        throw new \InvalidArgumentException(sprintf('Value `%s` Is not Defined In `%s`', $value, get_called_class()));
    }

    /**
     * {@inheritdoc}
     */
    public function compareTo(EnumValueObjectInterface $other): int
    {
        $thisOrdinal  = $this->getOrdinal();
        $otherOrdinal = $other->getOrdinal();
        if ($thisOrdinal === $otherOrdinal) {
            return 0;
        }
        return $thisOrdinal > $otherOrdinal ? 1 : -1;
    }

    /**
     * {@inheritdoc}
     *
     */
    final public function equals(ValueObject $other)
    {
        return $this->isSameType($other) && $this->isSameValue($other->getValue());
    }

    /**
     * Return whether the value is the same as this object.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    final private function isSameValue($value)
    {
        return $this->value === $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::getNameOf($this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrdinal(): int
    {
        return self::getOrdinalOf($this->value);
    }

    /**
     * Return the name of the constant
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Return enum list.
     *
     * @return array
     */
    final public static function getOptions()
    {
        self::parseEnumOptions();
        return self::$options;
    }

    /**
     * Return enum values.
     *
     * @return array
     */
    final public static function getValues()
    {
        self::parseEnumOptions();
        return array_values(self::$options);
    }

    /**
     * Return enum names.
     *
     * @return array
     */
    final public static function getNames()
    {
        self::parseEnumOptions();
        return array_keys(self::$options);
    }

   /**
     * Return the value of name.
     *
     * @param string $name
     *
     * @return integer|string
     *
     * @throws \InvalidArgumentException Throws if the given name is not defined.
     */
    final public static function getValueOf(string $name)
    {
        if (self::definedName($name)) {
            return self::$options[$name];
        }
        throw new \InvalidArgumentException(sprintf('Name `%s` Is Not Defined In `%s`', $name, get_called_class()));
    }

    /**
     * Return the name of value.
     *
     * @param mixed $value
     *
     * @return string
     *
     * @throws \InvalidArgumentException Throws if the given value is not defined.
     */
    final public static function getNameOf($value)
    {
        if (self::defined($value)) {
            return array_search($value, self::$options, true);
        }
        throw new \InvalidArgumentException(sprintf('Value `%s` Is not Defined In `%s`', $value, get_called_class()));
    }

    /**
     * Return the ordinal of value.
     *
     * @param mixed $value
     *
     * @return integer|null
     *
     * @throws \InvalidArgumentException Throws if the given value is not defined.
     */
    final public static function getOrdinalOf($value)
    {
        if (!self::defined($value)) {
            throw new \InvalidArgumentException(sprintf('Value `%s` Is not Defined In `%s`', $value, get_called_class()));
        }
        $values = self::getValues();
        return array_search($value, $values, true);
    }

    /**
     * {@inheritdoc}
     */
    public function validateValue($value): bool
    {
        if (self::definedValue($value)) {
            return true;
        }
        return false;
    }

    /**
     * Delegate to factory method to create a value object based on
     * constant name
     *
     * const STATUS_ACTIVE => createStatusActive()
     *
     * @param string $methodName
     * @param array  $args
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    final public static function __callStatic($methodName, array $args)
    {
        if (false !== stripos($methodName, 'create')) {
            $name = substr($methodName, 6);
            return self::create($name);
        }
        throw new \InvalidArgumentException('Invalid Function');
    }

    /**
     * Create Enum object.
     *
     * @param string $name CamelCase constant name.
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    final private static function create(string $name)
    {
        $name = self::toUpperCaseName($s2);
        if (!self::definedName($name)) {
            throw new \InvalidArgumentException(sprintf('Name Is Not Defined: %s', $name));
        }
        $value = self::getValueOf($name);
        return new self($value);
    }

    /**
     * Create Enum object from value
     *
     * @param mixed $value
     *
     * @return self
     *
     * @throws \InvalidArgumentException
     */
    final private static function createFromValue($value)
    {
        $name = self::getNameOf($value);
        return self::create($name);
    }

    /**
     * Convert CamelCase to UPPER_CASE.
     *
     * @param string $name CamelCase name.
     *
     * @return string
     */
    final private static function toUpperCaseName(string $name)
    {
        $s1 = preg_replace('/(.)([A-Z][a-z]+)/', '$1_$2', $name);
        $s2 = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $s1);
        return strtoupper($s2);
    }

    /**
     * Return whether the value is defined in the class.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    final public static function definedValue(string $value)
    {
        self::parseEnumOptions();
        return in_array($value, self::$options, true);
    }

    /**
     * Return whether the name is defined in the class.
     *
     * @param string $name
     *
     * @return boolean
     */
    final public static function definedName(string $name)
    {
        self::parseEnumOptions();
        return isset(self::$options[$name]);
    }

    /**
     * Parse enum options
     *
     * @return void
     */
    final private static function parseEnumOptions()
    {
        if (!isset(self::$options)) {
            $class = get_called_class();
            $refClass = new \ReflectionClass($class);
            self::$options = $refClass->getConstants();
        }
    }
}
