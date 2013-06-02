<?php
namespace Smth\AjaxAuthBundle\Security\Authentication;
 
use Symfony\Component\Security\Core\User\UserProviderInterface,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\Exception\UsernameNotFoundException,
    Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use /*Smth\AjaxAuthBundle\Service\Service,*/
    Smth\AjaxAuthBundle\Entity\User;

use Doctrine\ORM\EntityManager;
 
class UserProvider implements UserProviderInterface
{
    /*private $service;*/
    private $em;
 
    public function __construct(/*Service $service,*/ EntityManager $em)
    {
        /*$this->service  = $service;*/
        $this->em       = $em;
    }
 
    public function loadUserByUsername($username)
    {
        if ($user = $this->findUserBy(array('email' => $username)))
            return $user;
 
        throw new UsernameNotFoundException(sprintf('No record found for user %s', $username));
    }
 
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }
 
    public function supportsClass($class)
    {
        return $class === 'Smth\AjaxAuthBundle\Entity\User';
    }
 
    protected function findUserBy(array $criteria)
    {
        $repository = $this->em->getRepository('Smth\AjaxAuthBundle\Entity\User');
        return $repository->findOneBy($criteria);
    }
}
