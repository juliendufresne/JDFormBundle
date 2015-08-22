<?php

namespace JD\FormBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder
            ->root('jd_form')
            ->addDefaultsIfNotSet()
            ->canBeDisabled()
        ;

        $this->addFormTypeSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $rootNode
     */
    private function addFormTypeSection(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
            ->arrayNode('form')
                ->info('Define the form types you want to use and their default options')
                ->addDefaultsIfNotSet()
                ->canBeDisabled()
                ->children()
                    ->arrayNode('array')
                        ->info('The type array allow you to display (hidden or text) a collection of value with a separator')
                        ->addDefaultsIfNotSet()
                        ->canBeDisabled()
                        ->children()
                            ->scalarNode('delimiter')
                                ->info('Define the default delimiter used between two items')
                                ->defaultValue(', ')
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('date')
                        ->info('The goal of this type is to have a default behaviour for all your date forms')
                        ->addDefaultsIfNotSet()
                        ->canBeDisabled()
                        ->children()
                            ->scalarNode('format')
                                ->info('@see http://symfony.com/doc/current/reference/forms/types/date.html#format')
                                ->defaultValue('dd/MM/yyyy')
                            ->end()
                            ->scalarNode('widget')
                                ->info('@see http://symfony.com/doc/current/reference/forms/types/date.html#widget')
                                ->defaultValue('single_text')
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('date_between')
                        ->info('The missing form type to declare a date interval')
                        ->addDefaultsIfNotSet()
                        ->canBeDisabled()
                        ->children()
                            ->scalarNode('from')
                                ->info('Define the type to use for the from clause')
                                ->defaultValue('jd_date')
                            ->end()
                            ->scalarNode('to')
                                ->info('Define the type to use for the to clause')
                                ->defaultValue('jd_date')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
