<?php
/**
 * File src/Exceptions/KeyNotFoundException.php
 *
 * Exception thrown for not existing array keys.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace kbATeam\TypeCast\Exceptions;

use Throwable;

/**
 * Class kbATeam\TypeCast\Exceptions\KeyNotFoundException
 *
 * Exception thrown for not existing array keys.
 *
 * @package kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class KeyNotFoundException extends \Exception
{
    /**
     * Construct the exception. Note: The message is NOT binary safe.
     * @link  https://php.net/manual/en/exception.construct.php
     * @param string    $name     The name of key that wasn't found.
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
            'Invalid key %s!',
            $name
        );
        parent::__construct($message, $code, $previous);
    }
}
