<?php

namespace League\Tactician\Bundle\BundlePlugin;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BundleWithPlugins
 *
 * @package League\Tactician\Bundle\BundlePlugin
 */
abstract class BundleWithPlugins extends Bundle
{
    /**
     * @var BundlePlugin[] $plugins
     */
    private $plugins = array();

    /**
     * @return string
     */
    abstract protected function getAlias();

    /**
     * @param BundlePlugin[] $plugins
     */
    public function __construct(array $plugins = array())
    {
        foreach ($plugins as $plugin) {
            $this->addPlugin($plugin);
        }
    }

    /**
     * @param BundlePlugin $plugin
     */
    private function addPlugin(BundlePlugin $plugin)
    {
        $this->plugins[] = $plugin;
    }

    /**
     * @return BundlePlugin[]
     */
    public function getPlugins()
    {
        return $this->plugins;
    }

    /**
     * @return ExtensionInterface
     */
    public function getContainerExtension()
    {
        return new ExtensionWithPlugins($this->getAlias(), $this->plugins);
    }
}