<?php

namespace Smth\AjaxAuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder,
	Symfony\Component\DependencyInjection\Loader, 
	Symfony\Component\DependencyInjection\Reference;

use Symfony\Component\Config\FileLocator;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AjaxAuthExtension extends Extension
{
	/**
	 * {@inheritDoc}
	 */
	public function load(array $configs, ContainerBuilder $container)
	{
		$configuration = new Configuration();
		$config = $this->processConfiguration($configuration, $configs);
		
		$loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
		$loader->load('services.yml');

		$this->configSuccessHandler( $config, $container );

		$container->setParameter('ajax_auth.user_registration.handler', $config['user_registration_handler']);
	}

	public function configSuccessHandler($config, $container)
	{
		$successHandler = $container->getDefinition('smth_ajax_auth.handler');
		$arguments = $successHandler->getArguments();
		
		$arguments['default_redirect_path'] = $config['default_redirect_path'];
		$arguments['always_use_default_path'] = $config['always_use_default_path'];
		$successHandler->setArguments($arguments);
	}
}
