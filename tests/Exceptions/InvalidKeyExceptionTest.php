<?php
/**
 * File tests/Exceptions/InvalidKeyExceptionTest.php
 *
 * DESCRIPTION
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
 * DESCRIPTION
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
