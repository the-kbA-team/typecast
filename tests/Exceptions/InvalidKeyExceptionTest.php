<?php
/**
 * File tests/Exceptions/InvalidKeyExceptionTest.php
 *
 * Test the invalid key exception.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast\Exceptions;

use kbATeam\TypeCast\Exceptions\InvalidKeyException;

/**
 * Class Tests\kbATeam\TypeCast\Exceptions\InvalidKeyExceptionTest
 *
 * Test the invalid key exception.
 *
 * @package Tests\kbATeam\TypeCast\Exceptions
 * @author  Gregor J.
 * @license MIT
 */
class InvalidKeyExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $ex = new InvalidKeyException();
        $this->assertInstanceOf('Exception', $ex);
        $this->assertEquals(
            'Array keys can only be string or integer',
            $ex->getMessage()
        );
    }
}
