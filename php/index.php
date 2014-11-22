<?php
// load Slim and Symfony PSR-0 autoloader
require 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespace('WalkingEmpire', __DIR__);

// create router instance
$slim = new \Slim\Slim(array(
    'debug' => true,
	'log.level' => \Slim\Log::DEBUG
));

$slim->setName("Walking Empire");

// obtain and set post data (JSON encoded)
\WalkingEmpire\App::setInput(json_decode(file_get_contents('php://input')));

$slim->get('/update_location', function() {
	echo json_encode(new \WalkingEmpire\LocationResponse());	
});

$slim->get('/check_cookie', function() {
    echo json_encode((new \WalkingEmpire\Login\Verifier())->processCookie());
});

$slim->post('/login', function() {
	$loginVerifier = new \WalkingEmpire\Login\Verifier();
	echo json_encode($loginVerifier->processToken());
});

$slim->run();


