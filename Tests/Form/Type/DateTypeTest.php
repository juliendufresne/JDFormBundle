<?php

namespace JD\FormBundle\Tests\Form\Type;

use JD\FormBundle\Form\Type\DateType;
use Symfony\Component\Form\Test\TypeTestCase;

final class DateTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = '25/02/2015';

        $type = new DateType();
        $form = $this->factory->create($type);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals(new \DateTime('2015-02-25'), $form->getData());

        $this->assertDateTimeEquals(new \DateTime('2015-02-25'), $form->getData());
        $this->assertEquals($formData, $form->getViewData());
    }
}
