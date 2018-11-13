<?php
/**
 * File tests/Exceptions/KeyNotFoundExceptionTest.php
 *
 * Test the array key not found exception.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\Exceptions\KeyNotFoundException;

/**
 * Class Tests\kbATeam\TypeCast\Exceptions\KeyNotFoundExceptionTest
 *
 * Test the array key not found exception.
 *
 * @package Tests\kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class KeyNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $ex = new KeyNotFoundException('abc');
        $this->assertInstanceOf('Exception', $ex);
        $this->assertEquals(
            'Invalid key abc!',
            $ex->getMessage()
        );
    }
}
