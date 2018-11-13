<?php
/**
 * File src/Exceptions/InvalidKeyException.php
 *
 * DESCRIPTION
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\TypeCastArray;
use Throwable;

/**
 * Class kbATeam\TypeCast\Exceptions\InvalidKeyException
 *
 * DESCRIPTION
 *
 * @package kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidKeyException extends \Exception
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
            'Array keys can only be %s',
            implode(' or ', TypeCastArray::allowedKeyTypes())
        );
        parent::__construct($message, $code, $previous);
    }
}
