<?php
namespace Smth\TestBundle\Authentication;

use Smth\AjaxAuthBundle\Security\Authentication\UserRegistrationHandler;
use Smth\TestBundle\Entity\User;

class UserRegisterHandler extends UserRegistrationHandler
{
	protected $doctrine;

	public function handleUser($publicUser){
		$ur = $this->doctrine->getRepository('SmthTestBundle:User');
		$user = $ur->findOneByEmail($publicUser->email);

		if(!$user){
			$user = new User;
			$user
				->setUsername($publicUser->email)
				->setEmail($publicUser->email)
				->setRoles(array('USER_ROLE'))
				->setPassword('test123')
			;
			$dm = $this->doctrine->getManager();
			$dm->persist($user);
			$dm->flush();
		} 

		$this->authenticateUser($user);
	}

	public function setDoctrine($doctrine)
	{
		$this->doctrine = $doctrine;
	}
}