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
use kbATeam\TypeCast\ITypeCast;

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
            sprintf(
                'Only instances of %s are allowed!',
                ITypeCast::class
            ),
            $ex->getMessage()
        );
    }
}
