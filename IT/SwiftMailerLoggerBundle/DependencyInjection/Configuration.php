<?php

namespace IT\SwiftMailerLoggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('it_swift_mailer_logger');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->scalarNode('level')
                    ->defaultValue('info')
                ->end()
                ->scalarNode('type')
                    ->defaultValue('rotating_file')
                ->end()
                ->scalarNode('path')
                    ->defaultValue('%kernel.logs_dir%/mailer.%kernel.environment%.log')
                ->end()
                ->integerNode('max_files')
                    ->defaultValue(10)
                ->end()
                ->booleanNode('enable_db_logger')
                    ->defaultFalse()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
