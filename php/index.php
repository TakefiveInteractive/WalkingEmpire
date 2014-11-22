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

$slim->get('/update_location', function() {
	echo json_encode(new \WalkingEmpire\LocationResponse());	
});

$slim->post('/login', function() {
	$loginVerifier = new \WalkingEmpire\Login\Verifier();
	echo json_encode($loginVerifier->process());
});

$slim->run();


