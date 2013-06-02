<?php

namespace Smth\AjaxAuthBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
	Symfony\Component\DependencyInjection\ContainerBuilder;

use Smth\AjaxAuthBundle\Security\Authentication\AjaxAuthFactory;

class AjaxAuthBundle extends Bundle
{
	public function build(ContainerBuilder $container)
    {
        // parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new AjaxAuthFactory());
    }
}
