<?php

namespace JD\FormBundle\Tests\Form\Type;

use JD\FormBundle\Form\Model\DateBetween;
use JD\FormBundle\Form\Type\DateBetweenType;
use Symfony\Component\Form\Test\TypeTestCase;

final class DateBetweenTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'from' => '2015-02-25',
            'to'   => '2015-02-25',
        ];

        $type    = new DateBetweenType('date', 'date');
        $options = ['widget' => 'single_text'];
        $form    = $this->factory->create($type, null, ['from_options' => $options, 'to_options' => $options]);

        $object = new DateBetween(new \DateTime('2015-02-25'), new \DateTime('2015-02-25'));

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view     = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
