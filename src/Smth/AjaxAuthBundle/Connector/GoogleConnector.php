<?php
namespace Smth\AjaxAuthBundle\Connector;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Smth\AjaxAuthBundle\Connector\cURL;

/**
 * Represents a class that loads User objects 
 * from the GooglePlus WebService for the authentication system.
 */
class GoogleConnector implements ConnectorInterface
{
	private $googleAuthUserUrl = "https://www.googleapis.com/oauth2/v2/userinfo";

	public function getUser($token){
		$curl = new cURL();
		$curl->headers[] = 'Authorization: OAuth '.$token;

		$response = $curl->get($this->googleAuthUserUrl);
		return $user = json_decode($response);
	}
}