<?php
/**
 * File tests/Exceptions/InvalidValueExceptionTest.php
 *
 * Test the invalid typecast value exception.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption;

/**
 * Class Tests\kbATeam\TypeCast\Exceptions\InvalidValueExceptionTest
 *
 * Test the invalid typecast value exception.
 *
 * @package Tests\kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidValueExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $ex = new InvalidTypeCastExeption();
        $this->assertInstanceOf('Exception', $ex);
        $this->assertEquals(
            'Only instances of kbATeam\TypeCast\TypeCastArray'
            . ' or kbATeam\TypeCast\TypeCastObject'
            . ' or kbATeam\TypeCast\TypeCastValue are allowed!',
            $ex->getMessage()
        );
    }
}
