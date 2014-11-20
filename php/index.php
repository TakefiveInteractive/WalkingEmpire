<?php
require 'vendor/autoload.php';

// create router instance
$app = new \Slim\Slim(array(
    'debug' => true,
	'log.level' => \Slim\Log::DEBUG
));

