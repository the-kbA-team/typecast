<?php
/**
 * File tests/Exceptions/PropertyNameNotFoundExceptionTest.php
 *
 * Test the object property not found exception.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\Exceptions\PropertyNameNotFoundException;

/**
 * Class Tests\kbATeam\TypeCast\Exceptions\PropertyNameNotFoundExceptionTest
 *
 * Test the object property not found exception.
 *
 * @package Tests\kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class PropertyNameNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $ex = new PropertyNameNotFoundException('abc');
        $this->assertInstanceOf('Exception', $ex);
        $this->assertEquals(
            'Invalid property abc!',
            $ex->getMessage()
        );
    }
}
