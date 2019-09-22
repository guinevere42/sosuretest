<?php
namespace Sfauth\User;
 
use Symfony\Component\Security\Core\User\UserInterface;
 
class User implements UserInterface
{
    private $username;
    private $password;
    private $roles;
 
    public function __construct(string $username, string $password, string $roles)
    {
        if (empty($username))
        {
            throw new \InvalidArgumentException('Must provide a username.');
        }
 
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }
 
    public function getUsername()
    {
        return $this->username;
    }
 // allowed to change password => password ?
    public function getPassword()
    {
        return $this->password;
    }
 
    public function getRoles()
    {
        return explode(",", $this->roles);
    }
 
    public function getSalt()
    {
        return '';
    }
 
    public function eraseCredentials() {}
}