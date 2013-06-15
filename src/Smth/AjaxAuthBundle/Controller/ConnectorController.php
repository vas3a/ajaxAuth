<?php

namespace Smth\AjaxAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ConnectorController extends Controller
{
	public function connectAction(Request $request, $serviceName)
	{
		$service = $this->get('smth_ajax_auth.connector.'.$serviceName);		
		$user = $service->getUser($token = $request->request->get('token'));

		$userRegistrationHandlerClass = $this->container
			->getParameter('ajax_auth.user_registration.handler');

		$userRegistrationHandlerService = $this->get($userRegistrationHandlerClass);
		$userRegistrationHandlerService->handleUser($user);

		return $userRegistrationHandlerService->getResponse();
	}
}