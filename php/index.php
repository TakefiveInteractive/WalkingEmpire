<?php
// load Slim and Symfony PSR-0 autoloader
require 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\ClassLoader\ApcClassLoader;

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
        $loader = new UniversalClassLoader();
        $loader->registerNamespace('WalkingEmpire', __DIR__);

        $this->loader = new ApcClassLoader('ld_', $loader);
        $this->loader->register();

        // create router instance
        $this->slim = new \Slim\Slim(array(
            'debug' => true,
            'log.level' => \Slim\Log::DEBUG
        ));

        $this->slim->setName("Walking Empire");


    }
    
    public function main() {

        // since almost 100% responses are JSON, we set the Content-Type here.
        header('Content-Type: application/json');

        $this->slim->post('/check_cookie', function() {
            echo json_encode((new \WalkingEmpire\Login\Verifier())->processCookie());
        });

        $this->slim->post('/login', function() {
            $loginVerifier = new \WalkingEmpire\Login\Verifier();
            echo json_encode($loginVerifier->processToken());
        });

        // Hook to verify that the input is well-formed. This must be done using hooks as early as possible 
        // because halt can only be called in Slim callbacks, never in outer scope.
        $this->slim->hook(
            'slim.before',
            function() {
                // obtain and set post data (JSON encoded)
                $postData = file_get_contents('php://input');
                $decodedPostData = json_decode($postData);
 
                // check if input is valid
                if (strlen($postData) != 0
                    && ($decodedPostData === FALSE || $decodedPostData === NULL || !is_object($decodedPostData))) {
                    // halt application in case of failed JSON decode and non-empty input
                    // in addition, input data must decode to an object (enforced by API protocol).
                    $this->slim->halt(403, json_encode(new \WalkingEmpire\Login\Result(false, "Malformed JSON request.")));
                } else {
                    // load data
                    \WalkingEmpire\App::setInput($decodedPostData);
                }
            }
        );

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
            $userManager = new \WalkingEmpire\UserManager();
            $userManager->updateLocation();

            // fetch location info of other users
            $result1 = $userManager->getOtherUserLocations();
            // fetch information about nearby bases
            $result2 = (new \WalkingEmpire\BaseManager())->queryAllBases();
            // final data structure is the combination of the two
            $finalResult = \WalkingEmpire\Login\Result::mergeResults($result1, $result2, "users", "bases");
            echo json_encode($finalResult);
        });

        $this->slim->post('/add_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->addBase());
        });

        $this->slim->post('/lookup_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->getBase());
        });

        $this->slim->post('/fought_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->foughtBase());
        });

        $this->slim->post('/takeover_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->takeOverBase());
        });

        $this->slim->post('/destroy_base', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->destroyBase());
        });

        $this->slim->post('/build_structure', function() {
            $baseManager = new \WalkingEmpire\BaseManager();
            echo json_encode($baseManager->buildStructure());
        });

        $this->slim->get('/server_stats', function() {
            // clear the JSON header and reset it to text/html to accomodate phpinfo();
            header_remove('Content-Type');
            header('Content-Type: text/html');
            phpinfo();
        });

        $this->slim->run();
    }

}

$prog = new Main();
$prog->main();

