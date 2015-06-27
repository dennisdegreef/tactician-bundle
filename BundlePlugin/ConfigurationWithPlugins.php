<?php

namespace League\Tactician\Bundle\BundlePlugin;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class ConfigurationWithPlugins
 *
 * @package League\Tactician\Bundle\BundlePlugin
 */
class ConfigurationWithPlugins implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $root;

    /**
     * @var BundlePlugin[]
     */
    private $plugins;

    /**
     * @param string $root
     * @param BundlePlugin[] $plugins
     */
    public function __construct($root, array $plugins = [])
    {
        $this->plugins = $plugins;
        $this->root = $root;
    }

    /**
     * @return string
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->root);
        $this->addPlugins($rootNode);
        return $treeBuilder;
    }

    /**
     * @param NodeDefinition $rootNode
     * @param BundlePlugin $plugin
     */
    private function addPlugin(NodeDefinition $rootNode, BundlePlugin $plugin)
    {
        $pluginNode = $rootNode->children()->arrayNode($plugin->name());
        $plugin->addConfiguration($pluginNode);
    }

    /**
     * @param NodeDefinition $rootNode
     */
    protected function addPlugins(NodeDefinition $rootNode)
    {
        foreach ($this->plugins as $plugin) {
            $this->addPlugin($rootNode, $plugin);
        }
    }
}