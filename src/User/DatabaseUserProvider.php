<?php
namespace Sfauth\User;
 
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
//use Doctrine\DBAL\Connection;
use \PDO;
//use Sfauth\User\User;
 
class DatabaseUserProvider implements UserProviderInterface
{
    private $connection;
 
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
 
    public function loadUserByUsername($username)
    {
        return $this->getUser($username);
    }
 
    private function getUser($username)
    {
        $sql = "SELECT * FROM sf_users WHERE username = :name";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("name", $username);
        $stmt->execute();
        $row = $stmt->fetch();
 
        if (!$row['username'])
        {
            $exception = new UsernameNotFoundException(sprintf('Username "%s" not found in the database.', $row['username']));
            $exception->setUsername($username);
            throw $exception;
        }
        else
        {
            return new User($row['username'], $row['password'], $row['roles']);
        }
    }
 
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User)
        {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }
 
        return $this->getUser($user->getUsername());
    }
 
    public function supportsClass($class)
    {
        return 'Sfauth\User\User' === $class;
    }
}