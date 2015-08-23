<?php

namespace JD\FormBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectRepository;
use JD\FormBundle\Form\DataTransformer\EntityToIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
final class EntityHiddenType extends AbstractType
{
    /**
     * @var string
     */
    private $property;
    /**
     * @var string|null
     */
    private $className;
    /**
     * @var ObjectRepository|null
     */
    private $repository;

    /**
     * @param ObjectRepository $repository
     * @param string           $className
     * @param string           $property
     */
    public function __construct(ObjectRepository $repository = null, $className = null, $property = 'id')
    {
        $this->property   = $property;
        $this->className  = $className;
        $this->repository = $repository;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new EntityToIdTransformer($this->repository, $options['property']);
        $builder->addModelTransformer($transformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'invalid_message' => 'The entity does not exist.',
                    'property'        => $this->property,
                    'repository'      => $this->repository,
                ]
            );

        $resolver->setAllowedTypes('property', 'string');
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * @return string
     */
    public function getName()
    {
        $name = 'hidden_entity';
        if (null !== $this->className) {
            $name .= '_'.$this->className;
        }

        return $name;
    }
}
