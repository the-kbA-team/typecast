<?php
/**
 * File src/TypeCastArray.php
 *
 * Cast an array of values.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast;

use kbATeam\TypeCast\Exceptions\InvalidKeyException;
use kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption;
use kbATeam\TypeCast\Exceptions\KeyNotFoundException;

/**
 * Class kbATeam\TypeCast\TypeCastArray
 *
 * Cast multiple values in an array to the ones defined in this class.
 *
 * In order to cast arrays with numeric keys, just add a type cast class at offset 0.
 *
 * @package kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastArray implements ITypeCast, \ArrayAccess
{
    /**
     * @var array of array keys and their types.
     */
    protected $map;

    /**
     * @var array of allowed array key types.
     */
    protected static $allowedKeyTypes = [
        'string',
        'integer'
    ];

    /**
     * Return an array of allowed array key types.
     * @return array
     */
    public static function allowedKeyTypes()
    {
        return static::$allowedKeyTypes;
    }

    /**
     * Validate the datatype of the array key.
     * @param mixed $key
     * @throws \kbATeam\TypeCast\Exceptions\InvalidKeyException
     */
    protected static function validateKey($key)
    {
        if (!in_array(gettype($key), static::$allowedKeyTypes, true)) {
            throw new InvalidKeyException();
        }
    }

    /**
     * TypeCastArray constructor.
     */
    public function __construct()
    {
        $this->map = [];
    }

    /**
     * Cast the values of the given array to the typecast information defined in this
     * class.
     *
     * @param array $array The raw data to be typecasted.
     * @return array The same data structure as the input, but casted to the
     *                                   typecasting information defined in this
     *                                   class.
     * @throws \InvalidArgumentException in case the given value does not match the
     *                                   typecasting information defined in this
     *                                   class.
     */
    public function cast($array)
    {
        if (!is_array($array)) {
            throw new \InvalidArgumentException(sprintf('Expected an array, but got %s!', gettype($array)));
        }
        foreach ($array as $key => $value) {
            //is this a repeating array?
            $mapKey = $this->mapKey($key);
            //try to cast the value
            try {
                $array[$key] = $this[$mapKey]->cast($value);
            } catch (KeyNotFoundException $knfex) {
                //no key, no typecast, nothing happened.
            } catch (\InvalidArgumentException $iaex) {
                //unexpected value
                throw new \InvalidArgumentException(
                    sprintf(
                        'Unexpected value for key %s: %s',
                        $key,
                        $iaex->getMessage()
                    ),
                    0,
                    $iaex
                );
            }
        }
        return $array;
    }

    /**
     * Determine key for the map of this class from the data key.
     *
     * Data arrays with numeric keys repeat themselves by definition. Therefore only
     * the first array of this mapping is used to cast such data arrays.
     *
     * @param string|int $key
     * @return int|string
     */
    private function mapKey($key)
    {
        if (is_int($key)) {
            return 0;
        }
        return $key;
    }

    /**
     * Cast the values of the given array to the typecast information defined in this
     * class.
     *
     * The __invoke method is called when a script tries to call an object as a
     * function.
     *
     * @param array $array The raw data to be typecasted.
     * @return array The same data structure as the input, but casted to the
     *                                   typecasting information defined in this
     *                                   class.
     * @throws \InvalidArgumentException in case the given value does not match the
     *                                   typecasting information defined in this
     *                                   class.
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke($array)
    {
        return $this->cast($array);
    }


    /**
     * Whether a offset exists
     * @link  https://php.net/manual/en/arrayaccess.offsetexists.php
     * @param string|int $offset An offset to check for.
     * @return boolean true on success or false on failure.
     *                      The return value will be casted to boolean if
     *                      non-boolean was returned.
     * @since 5.0.0
     * @throws \kbATeam\TypeCast\Exceptions\InvalidKeyException
     */
    public function offsetExists($offset)
    {
        static::validateKey($offset);
        return array_key_exists($offset, $this->map);
    }

    /**
     * Offset to retrieve
     * @link  https://php.net/manual/en/arrayaccess.offsetget.php
     * @param string|int $offset The offset to retrieve.
     * @return \kbATeam\TypeCast\ITypeCast
     * @since 5.0.0
     * @throws \kbATeam\TypeCast\Exceptions\InvalidKeyException
     * @throws \kbATeam\TypeCast\Exceptions\KeyNotFoundException
     */
    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new KeyNotFoundException($offset);
        }
        return $this->map[$offset];
    }

    /**
     * Offset to set
     * @link  https://php.net/manual/en/arrayaccess.offsetset.php
     * @param string|int $offset The offset to assign the value to.
     * @param \kbATeam\TypeCast\ITypeCast $typeCast  The value to set.
     * @return void
     * @since 5.0.0
     * @throws \kbATeam\TypeCast\Exceptions\InvalidKeyException
     * @throws \kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption
     */
    public function offsetSet($offset, $typeCast)
    {
        static::validateKey($offset);
        if (!is_object($typeCast)
            || !$typeCast instanceof ITypeCast
        ) {
            throw new InvalidTypeCastExeption();
        }
        $this->map[$offset] = $typeCast;
    }

    /**
     * Offset to unset
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
     * @param string|int $offset The offset to unset.
     * @return void
     * @since 5.0.0
     * @throws \kbATeam\TypeCast\Exceptions\InvalidKeyException
     */
    public function offsetUnset($offset)
    {
        static::validateKey($offset);
        unset($this->map[$offset]);
    }
}
