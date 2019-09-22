<?php
// src/Controller/Authen.php
namespace App\Controller;

//require_once './vendor/autoload.php';
use Symfony\Component\HttpFoundation\Response;
use \PDO;
use Symfony\Component\Security\Core\User\UserChecker;
use SfAuth\User\DatabaseUserProvider;
//use SfAuth\User\DatabaseAuthenProvider as DBAuthenProvider;
use Symfony\Component\Security\Core\Authentication\AuthenticationProviderManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
 
class Authen
{
    public function authenticate()
    {
	// get username and pw, check db, respond

	$pdo = new \PDO('mysql:dbname=authen;host=localhost', 'authen', 'lib4erty');
//	$result = $pdo->query('SELECT * FROM users');
//	$rows = $result->fetchAll();
	// var_dump($rows);

  	// init our custom db user provider
	$userProvider = new DatabaseUserProvider($pdo);
 
 // we'll use default UserChecker, it's used to check additional checks like account lock/expired etc.
 // you can implement your own by implementing UserCheckerInterface interface
 $userChecker = new UserChecker();
 
 // init our custom db authentication provider
 $dbProvider = new DatabaseAuthenProvider(
     $userProvider,
     $userChecker,
     'frontend'
 );

// init authentication provider manager
$authenticationManager = new AuthenticationProviderManager(array($dbProvider));
 
try {
    // init un/pw, usually you'll get these from the $_POST variable, submitted by the end user
    $username = 'authen';
    $password = 'lib4erty';
 
    // get unauthenticated token
    $unauthenticatedToken = new UsernamePasswordToken(
        $username,
        $password,
        'frontend'
    );
 
    // authenticate user & get authenticated token
    $authenticatedToken = $authenticationManager->authenticate($unauthenticatedToken);
 
    // we have got the authenticated token (user is logged in now), it can be stored in a session for later use
    echo $authenticatedToken;
    echo "\n";
} catch (AuthenticationException $e) {
    echo $e->getMessage();
    echo "\n";
}
        return new Response(
//            '<html><body>USERS: '.var_dump($rows).'</body></html>'
        );
    }
}
