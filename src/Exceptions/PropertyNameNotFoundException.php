<?php
/**
 * File src/Exceptions/PropertyNameNotFoundException.php
 *
 * Exception in case a not existing property of a typecast object is requested.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast\Exceptions;

use Throwable;

/**
 * Class kbATeam\TypeCast\Exceptions\PropertyNameNotFoundException
 *
 * Exception in case a not existing property of a typecast object is requested.
 *
 * @package kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class PropertyNameNotFoundException extends \Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link  https://php.net/manual/en/exception.construct.php
     * @param string    $name     Property name
     * @param int       $code     [optional] The Exception code.
     * @param Throwable $previous [optional] The previous throwable used for the
     *                            exception chaining.
     * @since 5.1.0
     */
    public function __construct(
        $name,
        $code = 0,
        \Throwable $previous = null
    ) {
        $message = sprintf(
            'Invalid property %s!',
            $name
        );
        parent::__construct($message, $code, $previous);
    }
}
