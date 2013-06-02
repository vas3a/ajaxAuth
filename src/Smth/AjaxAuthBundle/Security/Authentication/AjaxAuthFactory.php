<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;
 
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\FormLoginFactory;
 
class AjaxAuthFactory extends FormLoginFactory
{
    public function getKey()
    {
        return 'ajax-auth';
    }
 
    protected function getListenerId()
    {
        return 'security.authentication.listener.form';
    }
 
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $provider = 'ajax_auth.security.authentication.provider.'.$id;
        $container
            ->setDefinition($provider, new DefinitionDecorator('ajax_auth.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(2, $id)
        ;
 
        return $provider;
    }
}