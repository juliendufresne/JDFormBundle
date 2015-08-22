<?php

namespace JD\FormBundle\DependencyInjection;

use JD\FormBundle\Form\Type\DateBetweenType;
use JD\FormBundle\Form\Type\DateType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 *
 */
final class JDFormExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        if (false === $mergedConfig['enabled']) {
            return;
        }
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('forms.yml');
        if (true === $mergedConfig['form']['enabled']) {
            $this->loadFormTypes($mergedConfig['form'], $container);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadFormTypes(array $config, ContainerBuilder $container)
    {
        $callIfEnabled = [
            'array'        => 'loadArrayFormType',
            'date'         => 'loadDateFormType',
            'date_between' => 'loadDateBetweenFormType',
        ];
        foreach ($callIfEnabled as $configName => $methodName) {
            if (true === $config[$configName]['enabled']) {
                call_user_func([$this, $methodName], $config[$configName], $container);
            }
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadArrayFormType(array $config, ContainerBuilder $container)
    {
        $serviceId = 'jd_form.form_type.array';
        $types     = ['hidden', 'text'];
        foreach ($types as $type) {
            $typeDef = new DefinitionDecorator($serviceId);
            $typeDef
                ->setArguments([$type, $config['delimiter']])
                ->addTag('form.type', ['alias' => 'array_'.$type]);
            $container->setDefinition($serviceId.'_'.$type, $typeDef);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadDateFormType(array $config, ContainerBuilder $container)
    {
        $typeDef = new Definition(DateType::class);
        $typeDef
            ->setArguments([$config['widget'], $config['format']])
            ->addTag('form.type', ['alias' => 'jd_date']);
        $container->setDefinition('jd_form.form_type.date', $typeDef);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadDateBetweenFormType(array $config, ContainerBuilder $container)
    {
        $typeDef = new Definition(DateBetweenType::class);
        $typeDef
            ->setArguments([$config['from'], $config['to']])
            ->addTag('form.type', ['alias' => 'date_between']);
        $container->setDefinition('jd_form.form_type.date_between', $typeDef);
    }
}
