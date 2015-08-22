<?php

namespace JD\FormBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * The purpose of this type is to share the same configuration for every date type in your application.
 */
final class DateType extends AbstractType
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $widget;

    /**
     * @param string $format
     * @param string $widget
     */
    public function __construct($widget = 'single_text', $format = 'dd/MM/yyyy')
    {
        $this->format = $format;
        $this->widget = $widget;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(
            [
                'format' => $this->format,
                'widget' => $this->widget,
            ]
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'date';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'jd_date';
    }
}
