<?php
/**
 * File src/ITypeCast.php
 *
 * DESCRIPTION
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast;

/**
 * Interface \kbATeam\TypeCast\ITypeCast
 *
 * @package kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
interface ITypeCast
{
    /**
     * Cast the given values to the type defined in this class.
     *
     * @param mixed $value The raw data to be typecasted.
     * @return mixed The same data structure as the input, but casted to the
     *                                   typecasting information defined in this
     *                                   class.
     * @throws \InvalidArgumentException in case the given value does not match the
     *                                   typecasting information defined in this
     *                                   class.
     */
    public function cast($value);

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
    public function __invoke($value);
}
