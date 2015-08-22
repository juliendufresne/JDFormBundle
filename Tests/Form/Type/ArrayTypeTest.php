<?php

namespace JD\FormBundle\Tests\Form\Type;

use JD\FormBundle\Form\Type\ArrayType;
use Symfony\Component\Form\Test\TypeTestCase;

final class ArrayTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getArrayTypeOption
     *
     * @param string $type
     * @param string $delimiter
     * @param string $formData
     */
    public function testSubmitValidData($type, $delimiter, $formData)
    {
        $type = new ArrayType($type, $delimiter);
        $form = $this->factory->create($type);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        if (empty($formData)) {
            $this->assertEmpty($form->getData());
        } else {
            $this->assertEquals(explode($delimiter, $formData), $form->getData());
        }
        $this->assertEquals($formData, $form->getViewData());
    }

    public function getArrayTypeOption()
    {
        $types        = ['hidden', 'text'];
        $delimiters   = [', ', '|'];
        $dataProvider = [];
        foreach ($types as $type) {
            foreach ($delimiters as $delimiter) {
                $dataProvider[] = [
                    'type'      => $type,
                    'delimiter' => $delimiter,
                    'formData'  => "",
                ];
                $dataProvider[] = [
                    'type'      => $type,
                    'delimiter' => $delimiter,
                    'formData'  => 1,
                ];
                $dataProvider[] = [
                    'type'      => $type,
                    'delimiter' => $delimiter,
                    'formData'  => '1'.$delimiter.'2',
                ];
                $dataProvider[] = [
                    'type'      => $type,
                    'delimiter' => $delimiter,
                    'formData'  => '1'.$delimiter.'2'.$delimiter.'3',
                ];
            }
        }

        return $dataProvider;
    }
}
