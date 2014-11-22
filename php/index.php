<?php
// load Slim and Symfony PSR-0 autoloader
require 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

class Main {

    private $authenticatedPaths = array(
        "/update_location" => 1,
        "/create_base" => 1,
        "/fought_base" => 1
    );

    /**
     * Function to scan requests for potentially unauthenticated attempts.
     */
    private function checkCredentials($path) {
        if (isset($this->authenticatedPaths[$path])) {
            // in our list of potentially dangerous requests
            return (new \WalkingEmpire\Login\Verifier())->processCookie();
        } else {
            // good to go
            return TRUE;
        }
    }
    
    public function main() {
        
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

        $slim->get('/check_cookie', function() use ($slim) {
            echo json_encode((new \WalkingEmpire\Login\Verifier())->processCookie());
        });

        $slim->post('/login', function() use ($slim) {
            $loginVerifier = new \WalkingEmpire\Login\Verifier();
            echo json_encode($loginVerifier->processToken());
        });

        // Hook to verify that the user is authenticated
        $slim->hook(
            'slim.before.dispatch',     // just before the matching root is called
            function() use ($slim) {
                $cookieCheckResponse = $this->checkCredentials($slim->router()->getCurrentRoute()->getPattern());
                // if the verifier says no?
                if (isset($cookieCheckResponse->response) && $cookieCheckResponse->response === FALSE) {
                    // stop the request and return failed info
                    $this->halt(403, json_encode($cookieCheckResponse));
                }
            }
        );

        $slim->post('/update_location', function() use ($slim) {
            echo json_encode(new \WalkingEmpire\LocationResponse());
        });

       $slim->post('/create_base', function() use ($slim) {
            $baseManager = new \WalkingEmpire\BuildingManager();
            $baseManager->addBase();
        });

        $slim->post('/fought_base', function() {
        });

        $slim->run();
    }

}

main();

