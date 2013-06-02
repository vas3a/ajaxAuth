<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent; 
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
	Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Request,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\RedirectResponse;
 
class AuthenticationHandler
implements AuthenticationSuccessHandlerInterface,
		   AuthenticationFailureHandlerInterface
{
	private $router;
 
	public function __construct(Router $router)
	{
		$this->router = $router;
	}
 
	public function onInteractiveLoginEvent(InteractiveLoginEvent $event)
	{
		return $event->response = 
			$this->onAuthenticationSuccess($event->getRequest(), $event->getAuthenticationToken());
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token)
	{
		if ($targetPath = $request->getSession()->get('_security.target_path'))
			$url = $targetPath;
		else // Otherwise, redirect him to wherever you want
			$url = $this->router->generate('bla', array(
				'nickname' => $token->getUser()->getUsername()
			));

		if ($request->isXmlHttpRequest()) {
			$result = array('result' => 'login_succeded', 'redirect_url' => $url);
			return $this->ajaxResponse($result);
		} else {
			// If the user tried to access a protected resource and was forces to login
			// redirect him back to that resource
			return new RedirectResponse($url);
		}
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		if ($request->isXmlHttpRequest()) {
			$result = array('result' => 'login_failed', 'message' => $exception->getMessage());
			return $this->ajaxResponse($result);
		} else {
			// Create a flash message with the authentication error message
			$request->getSession()->setFlash('error', $exception->getMessage());
			$url = $this->router->generate('user_login');
 
			return new RedirectResponse($url);
		}
	}

	protected function ajaxResponse($result)
	{
		$response = new Response(json_encode($result));
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}
}
