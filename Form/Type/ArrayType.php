<?php

namespace JD\FormBundle\Form\Type;

use JD\FormBundle\Form\DataTransformer\ArrayToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
final class ArrayType extends AbstractType
{
    /**
     * @var string
     */
    private $defaultDelimiter;
    /**
     * @var string
     */
    private $parentType;

    /**
     * @param string $parentType
     * @param string $defaultDelimiter
     */
    public function __construct($parentType, $defaultDelimiter = ', ')
    {
        $this->defaultDelimiter = $defaultDelimiter;
        $this->parentType       = $parentType;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new ArrayToStringTransformer($options['delimiter']));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('delimiter', $this->defaultDelimiter);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return $this->parentType;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'array_'.$this->parentType;
    }
}
