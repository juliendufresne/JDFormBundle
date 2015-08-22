<?php

namespace JD\FormBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 */
final class EntityType extends AbstractType
{
    /**
     * @var ObjectRepository
     */
    private $repository;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @param ObjectRepository $repository
     * @param string           $className
     * @param string           $methodName
     */
    public function __construct(ObjectRepository $repository, $className, $methodName)
    {
        $this->repository = $repository;
        $this->className  = $className;
        $this->methodName = $methodName;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // We do not check if method exists because you may want to call a magic method
        $methodName = $this->methodName;

        $resolver->setDefaults(
            [
                'choices' => call_user_func([$this->repository, $methodName]),
                'class'   => $this->repository->getClassName(),
            ]
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'entity_'.$this->className;
    }
}
