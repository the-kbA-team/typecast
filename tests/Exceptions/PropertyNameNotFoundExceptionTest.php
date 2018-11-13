<?php
/**
 * File src/PropertyNameNotFoundExceptionTest.php
 *
 * DESCRIPTION
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
 * DESCRIPTION
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
