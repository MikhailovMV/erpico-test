<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require  __DIR__ . '/../vendor/autoload.php';

// Create Container
$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function() {
    return Twig::create(__DIR__ . '/../templates',
        ['cache' => __DIR__ . '/../cache']);
});

// Create App
$app = AppFactory::create();

// Add Twig-View Middleware
$app->add(TwigMiddleware::createFromContainer($app));

// Example route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->get('view')->render($response, 'hello.twig', [
        'name' => $args['name']
    ]);
});



$app->get('/', function ($request, $response, $args) {
    $response->getBody()->write("Hello world!");
    //phpinfo();
	$dsn = 'mysql:host=localhost;dbname=rkc;charset=utf8';
	$usr = 'newuser';
	$pwd = 'password';
	$pdo = new \FaaPz\PDO\Database($dsn, $usr, $pwd);

	

	// SELECT * FROM users WHERE id = ?
	$selectStatement = $pdo->select()->from('evidences');
	                       //->where('id', '=', 1);

	$stmt = $selectStatement->execute();
	$data = $stmt->fetch();
	print_r($data);

    return $response;
});

$app->run();