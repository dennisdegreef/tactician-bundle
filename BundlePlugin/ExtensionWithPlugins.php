<?php

namespace League\Tactician\Bundle\BundlePlugin;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class ExtensionWithPlugins
 *
 * @package League\Tactician\Bundle\BundlePlugin
 */
class ExtensionWithPlugins extends ConfigurableExtension
{
    /**
     * @var string
     */
    private $alias;

    /**
     * @var BundlePlugin[]
     */
    private $plugins;

    /**
     * @param string $alias
     * @param array $plugins
     */
    public function __construct($alias, array $plugins = [])
    {
        $this->plugins = $plugins;
        $this->alias = $alias;
    }

    /**
     * @return BundlePlugin[]
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        foreach ($this->plugins as $plugin) {
            $this->loadPlugin($container, $plugin, $mergedConfig);
        }
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     *
     * @return ConfigurationWithPlugins
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new ConfigurationWithPlugins($this->getAlias(), $this->plugins);
    }

    /**
     * @param ContainerBuilder $container
     * @param BundlePlugin     $plugin
     * @param array            $processedConfiguration
     */
    private function loadPlugin(ContainerBuilder $container, BundlePlugin $plugin, array $processedConfiguration)
    {
        $container->addClassResource(new \ReflectionClass(get_class($plugin)));
        $pluginConfiguration = $this->pluginConfiguration($plugin, $processedConfiguration);
        $plugin->load($pluginConfiguration, $container);
    }

    /**
     * @param BundlePlugin $plugin
     * @param array        $processedConfiguration
     *
     * @return array
     */
    private function pluginConfiguration(BundlePlugin $plugin, array $processedConfiguration)
    {
        if (!isset($processedConfiguration[$plugin->name()])) {
            return array();
        }
        return $processedConfiguration[$plugin->name()];
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }
}