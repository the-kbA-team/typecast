<?php
/**
 * File src/Exceptions/InvalidValueException.php
 *
 * DESCRIPTION
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\TypeCastArray;
use kbATeam\TypeCast\TypeCastValue;
use Throwable;

/**
 * Class kbATeam\TypeCast\Exceptions\InvalidValueException
 *
 * DESCRIPTION
 *
 * @package kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidTypeCastExeption extends \Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link  https://php.net/manual/en/exception.construct.php
     * @param int       $code     [optional] The Exception code.
     * @param Throwable $previous [optional] The previous throwable used for the
     *                            exception chaining.
     * @since 5.1.0
     */
    public function __construct(
        $code = 0,
        \Throwable $previous = null
    ) {
        $message = sprintf(
            'Only instances of %s are allowed!',
            implode(' or ', TypeCastValue::allowedValueTypes())
        );
        parent::__construct($message, $code, $previous);
    }
}
