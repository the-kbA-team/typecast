<?php
/**
 * File tests/TypeCastObjectTest.php
 *
 * Test typecasting values in an object.
 *
 * @package typecast
 * @author  Gregor J.
 * @license MIT
 */

namespace Tests\kbATeam\TypeCast;

use kbATeam\TypeCast\Exceptions\InvalidTypeCastExeption;
use kbATeam\TypeCast\Exceptions\PropertyNameNotFoundException;
use kbATeam\TypeCast\ITypeCast;
use kbATeam\TypeCast\TypeCastObject;
use kbATeam\TypeCast\TypeCastValue;

/**
 * Class Tests\kbATeam\TypeCast\TypeCastObjectTest
 *
 * Test typecasting values in an object.
 *
 * @package Tests\kbATeam\TypeCast
 * @author  Gregor J.
 * @license MIT
 */
class TypeCastObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test set, get, isset and unset functionality.
     */
    public function testSetGetIssetUnset()
    {
        $cast = new TypeCastObject();
        $cast->a = new TypeCastValue('string');
        $this->assertTrue(isset($cast->a));
        $this->assertInstanceOf(TypeCastValue::class, $cast->a);
        unset($cast->a);
        $this->assertFalse(isset($cast->a));
        $this->setExpectedException(PropertyNameNotFoundException::class);
        $a = $cast->a;
    }
    /**
     * Test setting an invalid typecast.
     * @param $value
     * @dataProvider \Tests\kbATeam\TypeCast\TypeCastValueTest::invalidTypeCasts()
     */
    public function testInvalidTypecasts($value)
    {
        $obj = new TypeCastObject();
        $this->setExpectedException(
            InvalidTypeCastExeption::class,
            sprintf(
                'Only instances of %s are allowed!',
                ITypeCast::class
            )
        );
        $obj->x = $value;
    }

    /**
     * Test casting all possible object combinations.
     */
    public function testSuccessfulTypecast()
    {
        $data = new \stdClass();
        $data->a = 123;
        $data->b = new \stdClass();
        $data->b->c = '12.3';
        $data->b->d = '0';
        $data->f = true;
        $expected = new \stdClass();
        $expected->a = '123';
        $expected->b = new \stdClass();
        $expected->b->c = 12.3;
        $expected->b->d = false;
        $expected->f = true;
        $cast = new TypeCastObject();
        $cast->a = new TypeCastValue('string');
        $cast->b = new TypeCastObject();
        $cast->b->c = new TypeCastValue('float');
        $cast->b->d = new TypeCastValue('bool');
        $cast->g = new TypeCastValue('string');
        $actual = $cast($data);
        $this->assertJsonStringEqualsJsonString(json_encode($expected), json_encode($actual));
    }

    /**
     * @return array of non-array values.
     */
    public static function anythingButObject()
    {
        return [
            ['abc'],
            [123],
            [12.3],
            [true],
            [false],
            [[]]
        ];
    }

    /**
     * Test the exception thrown for any value but an array.
     * @param mixed $value
     * @dataProvider anythingButObject
     */
    public function testCastingAnytingButObject($value)
    {
        $cast = new TypeCastObject();
        $cast->a = new TypeCastValue('string');
        $this->setExpectedException(\InvalidArgumentException::class);
        $cast($value);
    }

    /**
     * Test the nested exception, in case the given data structure is not as expected.
     * @param mixed $value
     * @dataProvider anythingButObject
     */
    public function testNestedException($value)
    {
        $cast = new TypeCastObject();
        $cast->a = new TypeCastObject();
        $data = new \stdClass();
        $data->a = $value;
        $this->setExpectedException(
            \InvalidArgumentException::class,
            sprintf(
                'Unexpected value for property a: Expected an object, but got %s!',
                gettype($value)
            )
        );
        $cast($data);
    }
}
