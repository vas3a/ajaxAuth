<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;

use Symfony\Component\Security\Core\User\UserInterface,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

abstract class UserRegistrationHandler
{
	private $response;
	
	private $authService;

	public function __construct()
	{
		$this->response = array('result' => 'login_failed', 'message' => '');
	}

	public function setAuthService($authenticationService)
	{
		$this->authService = $authenticationService;
	}

	public function authenticateUser(UserInterface $user)
	{
		$this->response = $this->authService->authenticateUser($user);
	}

	public function authenticationFailed($message = '')
	{
		$this->response = array('result' => 'login_failed', 'message' => $message);	
	}

	public function getResponse()
	{
		return $this->response instanceof Response
			? $this->response
			: $this->ajaxResponse( $this->response );
	}

	protected function ajaxResponse($result)
	{
		$response = new Response(json_encode($result));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	abstract public function handleUser($publicUser);
}