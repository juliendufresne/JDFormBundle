<?php

namespace JD\FormBundle\Form\Type;

use JD\FormBundle\Form\Model\DateBetween;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
final class DateBetweenType extends AbstractType
{
    /**
     * @var string
     */
    private $fromType;

    /**
     * @var string
     */
    private $toType;

    /**
     * @param string $fromType
     * @param string $toType
     */
    public function __construct($fromType = 'jd_date', $toType = 'jd_date')
    {
        $this->fromType    = $fromType;
        $this->toType      = $toType;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fromOptions = array_merge(['label' => false], $options['from_options']);
        $toOptions   = array_merge(['label' => false], $options['to_options']);
        $builder->add('from', $options['from_type'], $fromOptions);
        $builder->add('to', $options['to_type'], $toOptions);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class'   => DateBetween::class,
                'from_type'    => $this->fromType,
                'to_type'      => $this->toType,
                'from_options' => [],
                'to_options'   => [],
            ]
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'date_between';
    }
}
