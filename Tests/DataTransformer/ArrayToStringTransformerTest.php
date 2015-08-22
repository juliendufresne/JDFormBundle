<?php

namespace JD\FormBundle\Tests\DataTransformer;

use JD\FormBundle\Form\DataTransformer\ArrayToStringTransformer;
use PHPUnit_Framework_TestCase;

/**
 *
 */
final class ArrayToStringTransformerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ArrayToStringTransformer
     */
    private $transformer;

    /**
     *
     */
    protected function setUp()
    {
        $this->transformer = new ArrayToStringTransformer('|');
    }

    /**
     *
     */
    protected function tearDown()
    {
        $this->transformer = null;
    }

    public function testTransform()
    {
        $result = $this->transformer->transform(range(1, 3));

        $this->assertEquals('1|2|3', $result);
    }

    public function testTransformNull()
    {
        $result = $this->transformer->transform(null);

        $this->assertEmpty($result);
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testTransformWrongData()
    {
        $this->transformer->transform(new \stdClass());
    }

    public function testReverseTransform()
    {
        $result = $this->transformer->reverseTransform('1|2|3');

        $this->assertEquals(range(1, 3), $result);
    }

    public function testReverseTransformNull()
    {
        $result = $this->transformer->reverseTransform(null);

        $this->assertEmpty($result);
    }

    public function testReverseTransformEmpty()
    {
        $result = $this->transformer->reverseTransform('');

        $this->assertEmpty($result);
    }

    /**
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function testReverseTransformWrongData()
    {
        $this->transformer->reverseTransform(new \stdClass());
    }
}
