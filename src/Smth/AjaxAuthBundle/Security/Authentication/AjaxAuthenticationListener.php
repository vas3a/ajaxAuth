<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;
 
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
	Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\RedirectResponse;

class AjaxAuthenticationListener implements 
	AuthenticationSuccessHandlerInterface,
	AuthenticationFailureHandlerInterface
{  
	/**
	 * This is called when an interactive authentication attempt succeeds. This
	 * is called by authentication listeners inheriting from
	 * AbstractAuthenticationListener.
	 *
	 * @see SymfonyComponentSecurityHttpFirewallAbstractAuthenticationListener
	 * @param Request        $request
	 * @param TokenInterface $token
	 * @return Response the response to return
	 */
	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		if ($request->isXmlHttpRequest()) {
			$result = array('success' => true);
			$response = new Response(json_encode($result));
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}
	}
 
	/**
	 * This is called when an interactive authentication attempt fails. This is
	 * called by authentication listeners inheriting from
	 * AbstractAuthenticationListener.
	 *
	 * @param Request                 $request
	 * @param AuthenticationException $exception    
	 * @return Response the response to return
	 */
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		if ($request->isXmlHttpRequest()) {
			$result = array('success' => false, 'message' => $exception->getMessage());
			$response = new Response(json_encode($result));
			$response->headers->set('Content-Type', 'application/json');
			return $response;
		}
	}
}