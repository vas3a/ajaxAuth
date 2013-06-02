<?php

namespace Smth\AjaxAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ConnectorController extends Controller
{
	public function loginAction(Request $request, $serviceName)
	{
		$service = $this->get('smth_ajax_auth.connector.'.$serviceName);		
		$user = $service->getUser($token = $request->request->get('token'));
		die($user->email);
	}
}