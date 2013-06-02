<?php
namespace Smth\AjaxAuthBundle\Connector;

/**
 * Represents a class that loads User objects 
 * from some webservices for the authentication system.
 */
interface ConnectorInterface
{
	/**
	 * Loads the user for the given token.
     *
     * @param string $token
     *
     * @return stdClass User
	 */
	public function getUser($token);
}