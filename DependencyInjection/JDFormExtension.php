<?php

namespace JD\FormBundle\DependencyInjection;

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
        if (true === $config['array']['enabled']) {
            $this->loadArrayFormType($container, $config['array']);
        }

        $callIfEnabled = [
            'date' => [
                'arguments' => [
                    $config['date']['widget'],
                    $config['date']['format'],
                ],
                'alias' => 'jd_date',
            ],
            'date_between' => [
                'arguments' => [
                    $config['date_between']['from'],
                    $config['date_between']['to'],
                ],
                'alias' => 'date_between',
            ],
        ];

        foreach ($callIfEnabled as $configName => $options) {
            if (true === $config[$configName]['enabled']) {
                $this->loadFormType($container, $options['arguments'], $options['alias']);
            }
        }
    }

    private function loadFormType(ContainerBuilder $container, $arguments, $tagAlias)
    {
        $typeDef = new Definition(DateType::class);
        $typeDef
            ->setArguments($arguments)
            ->addTag('form.type', ['alias' => $tagAlias]);
        $container->setDefinition('jd_form.form_type.'.$tagAlias, $typeDef);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function loadArrayFormType(ContainerBuilder $container, array $config)
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
}
