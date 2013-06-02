<?php

namespace Smth\AjaxAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
	public function indexAction($name = '')
	{
		return $this->render( 'AjaxAuthBundle:Default:index.html.twig',
			array('name'=>$name) );
	}
	public function checkAction($value='')
	{
		return new Response('test check action');
	}
}