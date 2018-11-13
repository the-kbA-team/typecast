<?php
/**
 * File tests/TypeCastValueTest.php
 *
 * Test typecasting a single value.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast;

use kbATeam\TypeCast\TypeCastValue;

/**
 * Class Tests\kbATeam\TypeCast\TypeCastValueTest
 *
 * Test typecasting a single value.
 *
 * @package Tests\kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastValueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test string casting.
     */
    public function testToStringCasting()
    {
        $string = new TypeCastValue('string');
        $this->assertSame('123', $string(123));
    }

    public static function validNumbers()
    {
        return [
            //input value     float int   bool
            ['12',            12.0, 12,   true ],
            ["\0\t\r\n3\x0b", 3.0,  3,    true ],
            ['  4.56 ',       4.56, 4,    true ],
            ['',              null, null, null ],
            ['   ',           null, null, null ],
            [78.9,            78.9, 78,   true ],
            [0.4,             0.4,  0,    true ],
            [1,               1.0,  1,    true ],
            [0,               0.0,  0,    false],
            [true,            1.0,  1,    true ],
            [false,           0.0,  0,    false],
            [null,            null, null, null ],
            [[],              null, null, null ],
            [[123],           null, null, null ],
            [new \stdClass(), null, null, null ]
        ];
    }

    /**
     * Test numeric typecasting.
     * @param mixed $value
     * @param float $float
     * @param int   $int
     * @param bool  $bool
     * @dataProvider validNumbers
     */
    public function testNumericCast($value, $float, $int, $bool)
    {
        $toFloat = new TypeCastValue('float');
        $toDouble = new TypeCastValue('double');
        $toInteger = new TypeCastValue('integer');
        $toInt = new TypeCastValue('int');
        $toBoolean = new TypeCastValue('boolean');
        $toBool = new TypeCastValue('bool');

        $this->assertSame($float, $toFloat($value));
        $this->assertSame($float, $toDouble($value));
        $this->assertSame($int, $toInteger($value));
        $this->assertSame($int, $toInt($value));
        $this->assertSame($bool, $toBoolean($value));
        $this->assertSame($bool, $toBool($value));
    }

    /**
     * Test using an anonymous function.
     */
    public function testAnonymousFunction()
    {
        $sapToTime = new TypeCastValue(function ($value) {
            $time = strptime($value, '%Y%m%d%H%M%S');
            return mktime(
                $time['tm_hour'],
                $time['tm_min'],
                $time['tm_sec'],
                1,
                $time['tm_yday'] + 1,
                $time['tm_year'] + 1900
            );
        });
        $this->assertSame(1542101820, $sapToTime('20181113093700'));
    }

    /**
     * Return invalid typecast parameters.
     * @return array
     */
    public static function invalidTypeCasts()
    {
        return [
            [[]],
            [new \stdClass()],
            [true],
            [false],
            [null],
            [1],
            [0],
            ['decimal'],
            ['this\is::invalid']
        ];
    }

    /**
     * Test exception thrown in case of invalid parameters.
     * @param mixed $cast
     * @dataProvider invalidTypeCasts
     */
    public function testInvalidTypecasts($cast)
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new TypeCastValue($cast);
    }
}
