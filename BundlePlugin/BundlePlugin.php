<?php

namespace League\Tactician\Bundle\BundlePlugin;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Interface BundlePlugin
 *
 * @package League\Tactician\Bundle\BundlePlugin
 */
interface BundlePlugin
{
    /**
     * @return string
     */
    public function name();

    /**
     * @param array            $pluginConfiguration
     * @param ContainerBuilder $container
     *
     * @return mixed
     */
    public function load(array $pluginConfiguration, ContainerBuilder $container);

    /**
     * @param ArrayNodeDefinition $pluginNode
     *
     * @return mixed
     */
    public function addConfiguration(ArrayNodeDefinition $pluginNode);
}