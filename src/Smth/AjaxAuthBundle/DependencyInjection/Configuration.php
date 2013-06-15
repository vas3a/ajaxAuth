<?php

namespace Smth\AjaxAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('ajax_auth');

		// Here you should define the parameters that are allowed to
		// configure your bundle. See the documentation linked above for
		// more information on that topic.

		$rootNode
			->children()
				->scalarNode('default_redirect_path')->end()
				->scalarNode('always_use_default_path')->end()
				->scalarNode('user_registration_handler')->end()
			->end()
		;

		return $treeBuilder;
	}
}
