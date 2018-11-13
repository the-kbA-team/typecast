<?php
/**
 * File src/TypeCastObject.php
 *
 * Cast the properties of an object.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast;

use kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption;
use kbATeam\TypeCast\Exceptions\PropertyNameNotFoundException;

/**
 * Class kbATeam\TypeCast\TypeCastObject
 *
 * Cast multiple properties of an object to the ones defined in this class.
 *
 * @package kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastObject
{
    /**
     * @var array of array keys and their types.
     */
    protected $map;

    /**
     * @var array of allowed array key types.
     */
    protected static $allowedPropertyTypes = [
        'string',
        'integer'
    ];

    /**
     * Return an array of allowed array key types.
     * @return array
     */
    public static function allowedPropertyTypes()
    {
        return static::$allowedPropertyTypes;
    }

    /**
     * TypeCastObject constructor.
     */
    public function __construct()
    {
        $this->map = [];
    }

    /**
     * Cast the properties of an object according to this internal definitions.
     * @param object $object
     * @return object
     * @throws \InvalidArgumentException
     */
    public function cast($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException(sprintf('Expected an object, but got %s!', gettype($object)));
        }
        foreach ($this->map as $name => $type) {
            if (isset($object->{$name})) {
                try {
                    $object->{$name} = $type->cast($object->{$name});
                } catch (\InvalidArgumentException $iaex) {
                    //unexpected value
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Unexpected value for property %s: %s',
                            $name,
                            $iaex->getMessage()
                        ),
                        0,
                        $iaex
                    );
                }
            }
        }
        return $object;
    }

    /**
     * is utilized for reading data from inaccessible members.
     *
     * @param $name string
     * @return \kbATeam\TypeCast\TypeCastValue
     *         |\kbATeam\TypeCast\TypeCastArray
     *         |\kbATeam\TypeCast\TypeCastObject
     * @throws \kbATeam\TypeCast\Exceptions\PropertyNameNotFoundException
     * @link https://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __get($name)
    {
        if (!$this->__isset($name)) {
            throw new PropertyNameNotFoundException($name);
        }
        return $this->map[$name];
    }

    /**
     * run when writing data to inaccessible members.
     *
     * @param $name  string
     * @param $object \kbATeam\TypeCast\TypeCastValue
     *               |\kbATeam\TypeCast\TypeCastArray
     *               |\kbATeam\TypeCast\TypeCastObject
     * @return void
     * @throws \kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption
     * @link https://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __set($name, $object)
    {
        if (!is_object($object)
            || !in_array(get_class($object), TypeCastValue::allowedValueTypes(), true)
        ) {
            throw new InvalidTypeCastExeption();
        }
        $this->map[$name] = $object;
    }

    /**
     * is triggered by calling isset() or empty() on inaccessible members.
     *
     * @param $name string
     * @return bool
     * @link https://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->map);
    }

    /**
     * is invoked when unset() is used on inaccessible members.
     *
     * @param $name string
     * @return void
     * @link https://php.net/manual/en/language.oop5.overloading.php#language.oop5.overloading.members
     */
    public function __unset($name)
    {
        unset($this->map[$name]);
    }

    /**
     * The __invoke method is called when a script tries to call an object as a
     * function.
     * @param object $object
     * @return object
     * @throws \InvalidArgumentException
     * @link https://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.invoke
     */
    public function __invoke($object)
    {
        return $this->cast($object);
    }
}
