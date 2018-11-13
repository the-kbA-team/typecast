<?php
/**
 * File src/Exceptions/InvalidPropertyNameException.php.php *
 * DESCRIPTION
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\TypeCastObject;
use kbATeam\TypeCast\TypeCastValue;

/**
 * Class kbATeam\TypeCast\Exceptions\InvalidPropertyNameException
 *
 * DESCRIPTION
 *
 * @package kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidPropertyNameException extends \Exception
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
            'Property names can only be %s',
            implode(' or ', TypeCastObject::allowedPropertyTypes())
        );
        parent::__construct($message, $code, $previous);
    }
}
