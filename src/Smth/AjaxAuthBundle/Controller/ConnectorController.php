<?php

namespace Smth\AjaxAuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Smth\AjaxAuthBundle\Entity\User;

class ConnectorController extends Controller
{
	public function loginAction(Request $request, $serviceName)
	{
		$service = $this->get('smth_ajax_auth.connector.'.$serviceName);		
		$user = $service->getUser($token = $request->request->get('token'));

		$authService = $this->get('smth.security.authentication');

		$ur = $this->getDoctrine()->getRepository('AjaxAuthBundle:User');
		$user = $ur->findOneByUsername('vasea');

		return $authService->authenticateUser($user);
	}
}