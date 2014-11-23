<?php

namespace WalkingEmpire\Login;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use \WalkingEmpire\User;
use \WalkingEmpire\App;
use \Slim\Slim;

class Verifier {

	function __construct() {
	}

	function validateAccessToken($token) {
		// prepare an HTTPS request to some random facebook API
		$request = new \WalkingEmpire\Util\HTTPSRequest("https://graph.facebook.com/me?fields=id&access_token=" . $token);
		$response = $request->go();
		// response is in JSON format
		$decoded = json_decode($response);

		// if we get something other than error messaage, the token is valid
		if (is_array($decoded) && !empty($decoded['id']) || is_object($decoded) && !empty($decoded->id)) {
			return true;
		}
		return false;
	}

    const LOGIN_COOKIE_NAME = "userCookie";

    function setLoginCookie($cookie_val) {
        $app = Slim::getInstance();

        $app->setCookie(self::LOGIN_COOKIE_NAME, $cookie_val, '14 days');
    }

    function getLoginCookie() {
        $app = Slim::getInstance();
        $cookie = $app->getCookie(self::LOGIN_COOKIE_NAME);

        if (!empty($cookie)) {
            return $cookie;
        } else {
            return FALSE;
        }
    }

    private function getUserIdFromFacebook($token) {
        $session = new FacebookSession($token);

        /* make the API call to get user information */
        $request = new FacebookRequest(
          $session,
            'GET',
              '/me'
              );
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        // handle facebook response object
        return $graphObject->getProperty('id');
    }

    public function processCookie() {
        error_log("processCookie, ", 3, "/home/www-data/err.log");

        $cookie = $this->getLoginCookie();

        error_log("Cookie: " . $cookie . "\n", 3, "/home/www-data/err.log");

        if ($cookie === FALSE || !isset($cookie)) {
            return new Result(false, "Cookie not found");
        } else {
            $user = User::findUserIdByCookie($cookie);
            if ($user === FALSE || !isset($user)) {
                error_log("Rejected\n", 3, "/home/www-data/err.log");
                return new Result(false, "Invalid cookie: " . $cookie);
            } else {
                // set global fields
                $userID = User::findUserIdByCookie($cookie);
                $token = User::findFacebookIdByCookie($cookie);

                App::setLoggedIn($userID, $token, $cookie);
                error_log("Accepted\n", 3, "/home/www-data/err.log");
                error_log("Returning: " . json_encode(new Result(true, "")) . "\n", 3, "/home/www-data/err.log");
                return new Result(true, "");
            }
        }
    }

	public function processToken() {
        error_log("processToken, ", 3, "/home/www-data/err.log");

        // initialize facebook app
		FacebookSession::setDefaultApplication('783258861766530', '20433de1149ff2619a5a681f25ea74ea');

        if (isset(App::getInput()->token)) {
            $token = strip_tags(htmlspecialchars(App::getInput()->token));

            if ($this->validateAccessToken($token)) {
                // Sign in the user by generating random cookie
                $cookie = base64_encode(openssl_random_pseudo_bytes(32));
                $existing_cookie = User::findCookieByFacebookId($token);

                if (!isset($existing_cookie)) {
                    // did token change for the user?
                    $userID = $this->getUserIdFromFacebook($token);
                    $existing_cookie_usr = User::findCookieByUserId($userID);
                    if (isset($existing_cookie_usr))
                        $existing_cookie = $existing_cookie_usr;
                }

                // is there already a cookie allotted to the user?
                if (isset($existing_cookie)) {
                    error_log("existing cookie found: $existing_cookie, ", 3, "/home/www-data/err.log");

                    // cookie on iOS side probably expired
                    $user = new User($existing_cookie);
                    // update cookie
                    $ret = $user->setCookie($cookie);
                    if ($ret === FALSE)
                        return new Result(false, "Failed to set cookie in DB");
                    // retrieve userID (using new cookie now)
                    $userID = User::findUserIdByCookie($cookie);
                } else {
                    // encountered new user. create it.
                    $userID = $this->getUserIdFromFacebook($token);
                    $ret = User::createUser($userID, $token, $cookie);
                }
                // tell client to use our newest cookie
                $this->setLoginCookie($cookie);

                // set global fields
                App::setLoggedIn($userID, $token, $cookie);

                error_log("UserID: " . $userID . ", setCookie: " . $cookie . "\n", 3, "/home/www-data/err.log");
                
                return new Result(true, "Logged in");
            } else {
                return new Result(false, "Invalid token");
            }
        } else {
            return new Result(false, "Invalid payload: " . print_r(App::getInput(), TRUE));
        }
	}

}
