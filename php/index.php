<?php
// load Slim and Symfony PSR-0 autoloader
require 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

class Main {

    /**
     * URL whitelist. Those not in the list require valid cookie.
     */
    private $openPaths = array(
        "/login" => 1,
        "/check_cookie" => 1,
        "/server_stats" => 1
    );

    private $slim;

    private $loader;

    /**
     * Function to scan requests for potentially unauthenticated attempts.
     */
    private function checkCredentials($path) {
        if (isset($this->openPaths[$path])) {
            // no restriction. good to go
            return TRUE;
        } else {
            // in our list of potentially dangerous requests
            return (new \WalkingEmpire\Login\Verifier())->processCookie();
       }
    }

    public function __construct() {
        // init autoloader
        $this->loader = new UniversalClassLoader();
        $this->loader->register();

        $this->loader->registerNamespace('WalkingEmpire', __DIR__);

        // create router instance
        $this->slim = new \Slim\Slim(array(
            'debug' => true,
            'log.level' => \Slim\Log::DEBUG
        ));

        $this->slim->setName("Walking Empire");


    }
    
    public function main() {
        
        // obtain and set post data (JSON encoded)
        \WalkingEmpire\App::setInput(json_decode(file_get_contents('php://input')));

        // since almost 100% responses are JSON, we set the Content-Type here.
        header('Content-Type: application/json');

        $this->slim->get('/check_cookie', function() {
            echo json_encode((new \WalkingEmpire\Login\Verifier())->processCookie());
        });

        $this->slim->post('/login', function() {
            $loginVerifier = new \WalkingEmpire\Login\Verifier();
            echo json_encode($loginVerifier->processToken());
        });

        // Hook to verify that the user is authenticated
        $this->slim->hook(
            'slim.before.dispatch',     // just before the matching root is called
            function() {
                $cookieCheckResponse = $this->checkCredentials($this->slim->router()->getCurrentRoute()->getPattern());
                // if the verifier says no? (don't use isset cuz isset considers "FALSE" as not set)
                if (is_object($cookieCheckResponse)     // response is an object
                    && property_exists($cookieCheckResponse, "success")     // an object containing "success" field
                    && $cookieCheckResponse->success === FALSE) {           // "success" shows failed
                    // stop the request and return failed info
                    $this->slim->halt(403, json_encode($cookieCheckResponse));
                }
            }
        );

        $this->slim->post('/update_location', function() {
            echo json_encode((new \WalkingEmpire\BaseManager())->queryAllBases());
        });

        $this->slim->post('/add_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            $baseManager->addBase();
        });

        $this->slim->post('/lookup_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->getBase());
        });

        $this->slim->post('/fought_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->foughtBase());
        });

        $this->slim->post('/build_structure', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->buildStructure());
        });

        $this->slim->get('/server_stats', function() {
            header_remove('Content-Type');
            header('Content-Type: application/json');
            phpinfo();
        });

        $this->slim->run();
    }

}

$prog = new Main();
$prog->main();

