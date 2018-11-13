<?php
/**
 * File src/TypeCastValue.php
 *
 * Cast single values.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast;

/**
 * Class kbATeam\TypeCast\TypeCastValue
 *
 * Cast a single value to the one defined in the constructor.
 *
 * @package kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastValue implements ITypeCast
{
    /**
     * @var callable|\Closure
     */
    protected $cast;

    /**
     * @var array of scalar types.
     */
    protected static $scalarTypes = [
        'string',
        'double',
        'float',
        'integer',
        'int',
        'boolean',
        'bool'
    ];

    /**
     * @var array of gettype() return values that can be casted to numeric values.
     */
    protected static $numericCastable = [
        'string',
        'double',
        'float',
        'integer',
        'boolean'
    ];

    /**
     * TypeCastValue constructor.
     * @param string|callable|\Closure $cast Either the name of a scalar type
     *                                       (string, double, float, integer, int,
     *                                       boolean, bool) or a callable, or a
     *                                       Closure.
     * @throws \InvalidArgumentException
     */
    public function __construct($cast)
    {
        if (in_array($cast, static::$scalarTypes, true)) {
            $this->cast = static::scalarTypeMap($cast);
        } elseif (is_callable($cast) || $cast instanceof \Closure) {
            $this->cast = $cast;
        } else {
            throw new \InvalidArgumentException(
                __CLASS__
                . ' expects constructor parameter to be either the name of a scalar'
                . ' type, a callable or a Closure.'
            );
        }
    }

    /**
     * Map the name of a scalar type to a static function of this class.
     * @param string $type
     * @return string The callable name of a static function of this class.
     * @throws \LogicException in case you made a programming error an let an
     *                         unrecognized type through.
     */
    protected static function scalarTypeMap($type)
    {
        switch ($type) {
            case 'string':
                return static::class.'::toString';
            case 'double': //fall through
            case 'float':
                return static::class.'::toFloat';
            case 'integer': //fall through
            case 'int':
                return static::class.'::toInt';
            case 'boolean': //fall through
            case 'bool':
                return static::class.'::toBool';
            //@codeCoverageIgnoreStart
            default:
                throw new \LogicException(sprintf('Unexpected type %s', $type));
        }
        //@codeCoverageIgnoreEnd
    }

    /**
     * Cast the given value to the type defined in this class.
     *
     * @param mixed $value The raw data to be typecasted.
     * @return mixed The same data structure as the input, but casted to the
     *                                   typecasting information defined in this
     *                                   class.
     * @throws \InvalidArgumentException in case the given value does not match the
     *                                   typecasting information defined in this
     *                                   class.
     */
    public function cast($value)
    {
        return call_user_func($this->cast, $value);
    }

    /**
     * Cast the given values to the type defined in this class.
     *
     * The __invoke method is called when a script tries to call an object as a
     * function.
     *
     * @param mixed $value The raw data to be typecasted.
     * @return mixed The same data structure as the input, but casted to the
     *                                   typecasting information defined in this
     *                                   class.
     * @throws \InvalidArgumentException in case the given value does not match the
     *                                   typecasting information defined in this
     *                                   class.
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke($value)
    {
        return $this->cast($value);
    }

    /**
     * Return empty string in case the type is not castable to a numeric data type
     * and trim the value.
     * @param mixed $value
     * @return string|float|int|bool
     */
    protected static function prepareNumericCast($value)
    {
        if (!in_array(gettype($value), static::$numericCastable, true)) {
            return '';
        }
        if (is_string($value)) {
            return trim($value);
        }
        return $value;
    }

    /**
     * Cast to string.
     * @param mixed $value
     * @return string
     */
    public static function toString($value)
    {
        return (string)$value;
    }

    /**
     * Cast to float.
     * @param mixed $value
     * @return float|null
     */
    public static function toFloat($value)
    {
        $trimmed = static::prepareNumericCast($value);
        if ($trimmed === '') {
            return null;
        }
        return (float)$trimmed;
    }

    /**
     * Cast to integer.
     * @param mixed $value
     * @return int|null
     */
    public static function toInt($value)
    {
        $trimmed = static::prepareNumericCast($value);
        if ($trimmed === '') {
            return null;
        }
        return (int)$trimmed;
    }

    /**
     * Cast to boolean.
     * @param mixed $value
     * @return bool|null
     */
    public static function toBool($value)
    {
        $trimmed = static::prepareNumericCast($value);
        if ($trimmed === '') {
            return null;
        }
        return (bool)$trimmed;
    }
}
