<?php

namespace IT\SwiftMailerLoggerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class ITSwiftMailerLoggerExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->handleConfiguration($config, $container);
    }

    /**
     * Handles the bundle configuration
     *
     * @param array            $config
     * @param ContainerBuilder $container
     */
    protected function handleConfiguration(array $config, ContainerBuilder $container)
    {
        $container->setParameter('it.swift_mailer_logger.enable_db_logger', $config['enable_db_logger']);
    }

    /**
     * @inheritdoc
     *
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {

        $configs = $container->getExtensionConfig($this->getAlias());
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // get all bundles
        $bundles = $container->getParameter('kernel.bundles');

        // determine if MonologBundle is registered
        if (isset($bundles['MonologBundle'])) {

            $configMonolog = array(
                'handlers' => array(
                    'mailer' => array(
                        'level' => isset($config['level']) ? $config['level'] : 'info',
                        'type' => isset($config['type']) ? $config['type'] : 'rotating_file',
                        'path' => isset($config['path']) ? $config['path'] : '%kernel.logs_dir%/mailer.%kernel.environment%.log',
                        'channels' => array(
                            'mailer',
                        ),
                        'max_files' => isset($config['max_files']) ? $config['max_files'] : 10,
                    ),
                ),
            );

            $container->prependExtensionConfig('monolog', $configMonolog);

        }

    }


}
