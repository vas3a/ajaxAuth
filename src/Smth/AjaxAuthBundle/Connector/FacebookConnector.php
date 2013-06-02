<?php
namespace Smth\AjaxAuthBundle\Connector;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Represents a class that loads User objects 
 * from the Facebook WebService for the authentication system.
 */
class FacebookConnector implements ConnectorInterface
{
	private $fbGraphApiUrl = "https://graph.facebook.com/me?access_token=%s&fields=%s";
	
	private $fields = array(
		'email', 'first_name', 'last_name', 'verified'
	);

	public function getUser($token){
		$url = sprintf( $this->fbGraphApiUrl, $token, implode($this->fields,',') ); 
		return $user = json_decode(file_get_contents($url));
	}
}