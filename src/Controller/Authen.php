<?php
// src/Controller/Authen.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use \PDO;

class Authen
{
    public function authenticate()
    {
	// get username and pw, check db, respond

	$pdo = new \PDO('mysql:dbname=authen;host=localhost', 'authen', 'lib4erty');
	$result = $pdo->query('SELECT * FROM users');
	$rows = $result->fetchAll();
	// var_dump($rows);

        $number = random_int(0, 100);

        return new Response(
            '<html><body>USERS: '.var_dump($rows).'</body></html>'
        );
    }
}
