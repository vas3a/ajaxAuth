<?php

namespace Smth\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	public function indexAction($name = 'Smth Admin')
	{
		return $this->render( 'SmthTestBundle:Default:index.html.twig',
			array('name'=>$name) );
	}
}
