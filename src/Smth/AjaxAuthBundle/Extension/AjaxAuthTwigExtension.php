<?php
namespace Smth\AjaxAuthBundle\Extension;
use \Twig_Extension;
use \Twig_Function_Method;

class AjaxAuthTwigExtension
	extends Twig_Extension
{
	protected $router;

	public function __construct($router)
	{
		$this->router = $router;
	}
	
	public function getFunctions() {
		return array(
			'AjaxAuthScript' => new Twig_Function_Method(
				$this, 
				'getAjaxAuthScript', 
				array('needs_environment' => true, 'is_safe'=>array('html'))
			)
		 );
	}

	public function getName() {
		return 'ajax_auth';
	}

	private function getRoute($serviceName)
	{
		return $this->router->generate('_ajax_auth._connector',array('serviceName'=>$serviceName));
	}

	public function getAjaxAuthScript(\Twig_Environment $environment, $options = ''){
		$fb = array('includeFacebook'=>false);
		$g = array('includeGoogle'=>false);

		if($options['facebook'])
			$fb = array(
				'includeFacebook'=>true,
				'facebookAppId'=>$options['facebook'],
				'facebookConnectUrl'=>$this->getRoute('facebook')
			);
		
		if($options['google'])
			$g = array(
				'includeGoogle'=>true,
				'googleClientId'=>$options['google'],
				'googleConnectUrl'=>$this->getRoute('google')
			);

		$script = $environment->render(
			'AjaxAuthBundle:javascripts:ajax-auth-form-controller-minified.js.twig',
			array_merge($fb, $g)
		);

		return $script;
	}
}