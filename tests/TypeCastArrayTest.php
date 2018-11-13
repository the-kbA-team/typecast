<?php
/**
 * File tests/TypeCastArrayTest.php
 *
 * Test typecasting values in an array.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast;

use kbATeam\TypeCast\Exceptions\InvalidKeyException;
use kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption;
use kbATeam\TypeCast\Exceptions\KeyNotFoundException;
use kbATeam\TypeCast\TypeCastArray;
use kbATeam\TypeCast\TypeCastValue;

/**
 * Class Tests\kbATeam\TypeCast\TypeCastArrayTest
 *
 * Test typecasting values in an array.
 *
 * @package Tests\kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastArrayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test array access methods set, get, isset and unset.
     */
    public function testOffsetSetGetIssetAndUnset()
    {
        $arr = new TypeCastArray();
        $arr['a'] = new TypeCastValue('int');
        $this->assertTrue(isset($arr['a']));
        $this->assertInstanceOf(TypeCastValue::class, $arr['a']);
        unset($arr['a']);
        $this->assertFalse(isset($arr['a']));
        $this->setExpectedException(KeyNotFoundException::class);
        $cast = $arr['a'];
    }

    /**
     * Provide invalid names.
     * @return array
     */
    public static function invalidNames()
    {
        return [
            [12.3],
            [true],
            [false],
            [null],
            [new \stdClass()]
        ];
    }

    /**
     * Test exception thrown in case of an invalid key for array access.
     * @param mixed $key
     * @dataProvider invalidNames
     */
    public function testInvalidKeyNames($key)
    {
        $arr = new TypeCastArray();
        $this->setExpectedException(InvalidKeyException::class);
        $arr[$key] = new TypeCastValue('int');
    }

    /**
     * Test setting an invalid typecast.
     * @param $value
     * @dataProvider \Tests\kbATeam\TypeCast\TypeCastValueTest::invalidTypeCasts()
     */
    public function testInvalidTypecasts($value)
    {
        $arr = new TypeCastArray();
        $this->setExpectedException(InvalidTypeCastExeption::class);
        $arr['x'] = $value;
    }

    /**
     * Test casting all possible array combinations.
     */
    public function testSuccessfulTypecast()
    {
        $data = [
            'a' => 123,
            'b' => [
                //this has to be possible too
                '1',
                '2.1',
                '3.2'
            ],
            'c' => [
                //repeating numeric arrays with varying content
                [
                    'd' => '12.3',
                    'e' => '4.56'
                ],
                [
                    'd' => '7.89'
                ],
                [
                    'e' => '0'
                ]
            ],
            'f' => true
        ];
        $expected = [
            'a' => '123',
            'b' => [
                1.0,
                2.1,
                3.2
            ],
            'c' => [
                [
                    'd' => 12.3,
                    'e' => 4.56
                ],
                [
                    'd' => 7.89
                ],
                [
                    'e' => 0.0
                ]
            ],
            'f' => true
        ];
        $cast = new TypeCastArray();
        $cast['a'] = new TypeCastValue('string');
        $cast['b'] = new TypeCastArray();
        $cast['b'][0] = new TypeCastValue('float');
        $cast['c'] = new TypeCastArray();
        $cast['c'][0] = new TypeCastArray();
        $cast['c'][0]['d'] = new TypeCastValue('double');
        $cast['c'][0]['e'] = new TypeCastValue('double');
        $cast['g'] = new TypeCastValue('string');
        $actual = $cast($data);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array of non-array values.
     */
    public static function anythingButArray()
    {
        return [
            ['abc'],
            [123],
            [12.3],
            [true],
            [false],
            [null],
            [new \stdClass()]
        ];
    }

    /**
     * Test the exception thrown for any value but an array.
     * @param mixed $value
     * @dataProvider anythingButArray
     */
    public function testCastingAnytingButArray($value)
    {
        $cast = new TypeCastArray();
        $cast['a'] = new TypeCastValue('string');
        $this->setExpectedException(\InvalidArgumentException::class);
        $cast($value);
    }

    /**
     * Test the nested exception, in case the given data structure is not as expected.
     * @param mixed $value
     * @dataProvider anythingButArray
     */
    public function testNestedException($value)
    {
        $cast = new TypeCastArray();
        $cast['a'] = new TypeCastArray();
        $this->setExpectedException(
            \InvalidArgumentException::class,
            sprintf(
                'Unexpected value for key a: Expected an array, but got %s!',
                gettype($value)
            )
        );
        $cast(['a' => $value]);
    }

    public function testReadme()
    {

        //prepare typecast rules
        $cast = new TypeCastArray();
        $cast['myIntValue'] = new TypeCastValue('integer');
        $cast['myFloatValues'] = new TypeCastArray();
        $cast['myFloatValues'][0] = new TypeCastValue('float');
        $cast['mySettings'] = new TypeCastArray();
        $cast['mySettings']['a'] = new TypeCastValue('boolean');
        $cast['mySettings']['b'] = new TypeCastValue('boolean');

        //the raw data array
        $raw_data = [
            'myIntValue' => ' 123    ',
            'myFloatValues' => [
                '  3.00',
                '  4.50'
            ],
            'mySettings' => [
                'a' => '0',
                'b' => '1'
            ]
        ];

        $data = $cast($raw_data);
        echo serialize($data);
    }
}
