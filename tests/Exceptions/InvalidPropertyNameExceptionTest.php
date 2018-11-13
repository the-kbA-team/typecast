<?php
/**
 * File tests/Exceptions/InvalidPropertyNameExceptionTest.php
 *
 * DESCRIPTION
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\Exceptions\InvalidPropertyNameException;

/**
 * Class Tests\kbATeam\TypeCast\Exceptions\InvalidPropertyNameExceptionTest
 *
 * DESCRIPTION
 *
 * @package Tests\kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidPropertyNameExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $ex = new InvalidPropertyNameException();
        $this->assertInstanceOf('Exception', $ex);
        $this->assertEquals(
            'Property names can only be string or integer',
            $ex->getMessage()
        );
    }
}
