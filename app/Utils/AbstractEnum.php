<?php
/**
 *  Copyright (c) 2018 Webbing Brasil (http://www.webbingbrasil.com.br)
 *  All Rights Reserved
 *
 *  This file is part of the android project.
 *
 * @project exercicioemcasa
 * @file AbstractEnum.php
 * @author Danilo Andrade <danilo@webbingbrasil.com.br>
 * @date 10/09/18 at 11:02
 * @copyright  Copyright (c) 2017 Webbing Brasil (http://www.webbingbrasil.com.br)
 */

namespace App\Utils;

use ReflectionException;
use UnexpectedValueException;

abstract class AbstractEnum implements \JsonSerializable, \Serializable
{
    /**
     * List of labels for enums constants
     *
     * @var array
     */
    public static $labels = [];
    /**
     * Store existing constants in a static cache per object.
     *
     * @var array
     */
    protected static $cache = array();
    /**
     * Set name of default constant key
     * @var string
     */
    protected static $defaultKey = 'DEFAULT';
    private static $constCacheArray;
    /**
     * Set if is strict.
     *
     * @var bool
     */
    protected $_strict;

    /**
     * Enum value
     *
     * @var mixed
     */
    protected $value;

    /**
     * Creates a new value of some type.
     *
     * @param mixed|null $value Initial value
     * @param bool       $strict Provided for SplEnum compatibility
     *
     * @throws UnexpectedValueException if incompatible type is given.
     * @throws ReflectionException
     */
    public function __construct($value = null, $strict = false)
    {
        $this->_strict = (bool)$strict;
        $this->setValue($value);
    }

    /**
     * Return the array of labels
     *
     * @return array
     * @throws ReflectionException
     */
    public static function labels()
    {
        $result = [];
        foreach (static::values() as $value) {
            $result[] = static::label($value);
        }
        return $result;
    }

    /**
     * @return \Illuminate\Support\Collection|array
     * @throws ReflectionException
     */
    public static function values()
    {
        return self::items()->values();
    }

    /**
     * @return \Illuminate\Support\Collection|array
     * @throws ReflectionException
     */
    public static function items()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            self::$constCacheArray[$calledClass] = collect(self::getConstants(false));
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function transform(callable $callback)
    {
        return array_map($callback, self::choices(), self::values()->toArray(), self::keys()->toArray());
    }

    /**
     * Returns all enum constants.
     *
     * @param bool $includeDefault
     *
     * @throws ReflectionException
     *
     * @return array|mixed
     */
    public static function getConstants($includeDefault = true)
    {
        $className = get_called_class();
        if (!array_key_exists($className, static::$cache)) {
            $reflection = new \ReflectionClass($className);
            static::$cache[$className] = $reflection->getConstants();

            if (method_exists($className, 'boot')) {
                static::boot();
            }
        }

        $constants = self::$cache[$className];

        if ($includeDefault === false) {
            $constants = array_filter(
                $constants,
                function ($key) {
                    return $key !== self::$defaultKey;
                },
                ARRAY_FILTER_USE_KEY);
        }

        return $constants;
    }

    /**
     * Return a array with value/label pairs.
     *
     * @return array
     * @throws ReflectionException
     */
    public static function choices()
    {
        $result = [];
        foreach (static::values() as $value) {
            $result[$value] = static::label($value);
        }
        return $result;
    }

    /**
     * Check if enum key exists.
     *
     * @param string $name Name of the constant to validate
     * @param bool   $strict Case is significant when searching for name
     *
     * @throws ReflectionException
     *
     * @return bool
     */
    public static function isValidName($name, $strict = true)
    {
        $constants = static::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $constantNames = array_map('strtoupper', array_keys($constants));

        return in_array(strtoupper($name), $constantNames);
    }

    /**
     * Check if is valid enum value.
     *
     * @param      $value
     * @param bool $strict Case is significant when searching for name
     *
     * @throws ReflectionException
     *
     * @return bool
     */
    public static function isValidValue($value, $strict = true)
    {
        return in_array($value, static::toArray(), $strict);
    }

    /**
     * Returns all possible values as an array, except default constant.
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    public static function toArray()
    {
        return self::getConstants(false);
    }

    /**
     * Provided for compatibility with SplEnum.
     *
     * @see AbstractEnum::getConstants()
     *
     * @param bool $include_default Include `__default` and its value. Not included by default.
     *
     * @throws ReflectionException
     *
     * @return array
     */
    public static function getConstList($include_default = false)
    {
        return self::getConstants($include_default);
    }

    /**
     * Returns a value when called statically like so: MyEnum::SOME_VALUE() given SOME_VALUE is a class constant.
     *
     * @param $name
     * @param $arguments
     *
     * @throws ReflectionException
     * @throws \BadMethodCallException if enum does not exist
     *
     * @return AbstractEnum
     */
    public static function __callStatic($name, $arguments)
    {
        $array = static::toArray();
        if (isset($array[$name])) {
            return new static($array[$name]);
        }

        throw new \BadMethodCallException("No static method or enum constant '$name' in class ".get_called_class());
    }

    /**
     * @param int $value
     * @return mixed
     * @throws ReflectionException
     */
    public static function key($value)
    {
        return self::items()->search($value);
    }

    /**
     * @param      $key
     * @param null $default
     * @return mixed
     * @throws ReflectionException
     */
    public static function get($key, $default = null)
    {
        return self::items()->get($key);
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws ReflectionException
     */
    public static function toList()
    {
        return self::items()->flip();
    }

    /**
     * Returns the label for current value.
     *
     * @return string
     */
    public function getLabel()
    {
        return self::label($this->value);
    }

    /**
     * Returns the label for a given value.
     *
     * @param $value
     * @return string
     */
    private static function label($value)
    {
        $className = get_called_class();
        if (self::hasLabels() && isset(self::$labels[$className][$value])) {
            return (string)self::$labels[$className][$value];
        }
        return (string)$value;
    }

    /**
     * @param array $labels
     */
    protected static function setLabels(array $labels)
    {
        $className = get_called_class();
        self::$labels[$className] = $labels;
    }

    /**
     * Returns whether the labels property is defined on the actual class.
     *
     * @return bool
     */
    private static function hasLabels()
    {
        $className = get_called_class();
        return isset(self::$labels[$className]);
    }

    /**
     * Returns the enum key.
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    public function getKey()
    {
        return static::search($this->value);
    }

    /**
     * Return key for value.
     *
     * @param $value
     *
     * @throws ReflectionException
     *
     * @return false|int|string
     */
    public static function search($value)
    {
        return array_search($value, static::toArray(), true);
    }

    /**
     * Return string representation of the enum's value.
     *
     * @return string
     */
    public function __toString()
    {
        return strval($this->value);
    }

    /**
     * @param       $name
     * @param array $arguments
     * @return bool
     * @throws ReflectionException
     */
    public function __call($name, array $arguments)
    {
        if (strpos($name, 'is') === 0 && strlen($name) > 2 && ctype_upper($name[2])) {
            $constName = self::strToConstName(substr($name, 2));
            if (self::hasConst($constName)) {
                return $this->equalsByConstName($constName);
            }
        }
        trigger_error(
            sprintf('Call to undefined method: %s::%s()', static::class, $name),
            E_USER_WARNING
        );
    }

    /**
     * @param $str
     * @return string
     */
    private static function strToConstName($str)
    {
        if (!ctype_lower($str)) {
            $str = preg_replace('/\s+/u', '', ucwords($str));
            $str = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.'_', $str));
        }
        return strtoupper($str);
    }

    /**
     * Returns whether a const is present in the specific enum class.
     *
     * @param $const
     * @return bool
     * @throws ReflectionException
     */
    public static function hasConst($const)
    {
        return in_array($const, static::keys()->toArray());
    }

    /**
     * @return \Illuminate\Support\Collection|array
     * @throws ReflectionException
     */
    public static function keys()
    {
        return self::items()->keys();
    }

    /**
     * Returns whether the enum instance equals with a value of the same
     * type created from the given const name
     *
     * @param $const
     * @return bool
     * @throws ReflectionException
     */
    private function equalsByConstName($const)
    {
        return $this->equals(
            new static(constant(static::class.'::'.$const))
        );
    }

    /**
     * Compares one Enum with another.
     *
     * @param AbstractEnum|null $enum
     * @return bool
     */
    final public function equals(AbstractEnum $enum = null)
    {
        return $enum !== null && $this->getValue() === $enum->getValue() && get_called_class() == get_class($enum);
    }

    /**
     * Get enum value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set enum value.
     *
     * @param $value
     *
     * @throws ReflectionException
     */
    public function setValue($value)
    {
        $className = get_called_class();

        if (is_null($value)) {
            if (!self::isValidName(self::$defaultKey, $this->_strict)) {
                throw new UnexpectedValueException('Default value not defined in enum '.$className);
            }

            $value = self::getConstants()[self::$defaultKey];
        }

        if (!self::isValidValue($value, $this->_strict)) {
            throw new UnexpectedValueException("Value '$value' is not part of the enum ".get_called_class());
        }

        $this->value = $value;
    }

    /**
     * Specify data which should be serialized to JSON. This method returns data that can be serialized by json_encode()
     * natively.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->getValue();
    }

    public function serialize()
    {
        return serialize([static::$defaultKey => $this->value]);
    }

    public function unserialize($serialized)
    {
        $this->value = unserialize($serialized, ['allowed_classes' => [static::class]])[static::$defaultKey];
        $this->_strict = false;
    }
}
