<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;

use Symfony\Component\DependencyInjection\ContainerAware,
	Symfony\Component\Security\Http\Event\InteractiveLoginEvent,
	Symfony\Component\Security\Http\SecurityEvents,
	Symfony\Component\Security\Core\User\UserInterface,
	Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Component\HttpFoundation\Response,
	Symfony\Component\Security\Http\RememberMe\TokenBasedRememberMeServices;

class UserAuthentication extends ContainerAware
{
	/**
	 * Authenticate a user with Symfony Security
	 * 
	 * @param UserInterface $user
	 */
	public function authenticateUser(UserInterface $user)
	{
		$token = new UsernamePasswordToken($user, $user->getPassword(), 'secured_area', $user->getRoles());
		$this->container->get('security.context')->setToken($token);
		$request = $this->container->get('request');

		$response = $this->setRememberMe($request, $token);

		$event = $this->container->get('event_dispatcher')->dispatch(
			SecurityEvents::INTERACTIVE_LOGIN,
			new InteractiveLoginEvent($request, $token)
		);

		$responseContent = $event->response->getContent();
		$response->setContent($responseContent);
		return $response;
	}

	/**
	 * Remove curent user's authentication from Symfony Security
	 */
	public function deauthenticateUser()
	{
		$this->container->get('security.context')->setToken(null);
		$this->container->get('session')->invalidate();
	}

	public function setRememberMe($request, $token)
	{
		// $providerKey = 'secured_area';
		// $securityKey = $this->container->getParameter('secret');
		// $remembermeParameters = $this->container->getParameter('remember_me_params');
		// $userProvider = $this->container->get('user_provider');

		// $rememberMeService = new TokenBasedRememberMeServices(
		// 	array($userProvider), 
		// 	$securityKey, 
		// 	$providerKey, 
		// 	$remembermeParameters
		// );

		// $request->request->add(array('_remember_me'=>true));
		$response = new Response();
		// $rememberMeService->loginSuccess($request, $response, $token);

		return $response;
	}
}