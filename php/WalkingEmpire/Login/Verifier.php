<?php

namespace WalkingEmpire\Login;

use Facebook\FacebookSession;
use WalkingEmpire\User;
use WalkingEmpire\App;
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
		if (isset($decoded['id'])) {
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

        if (isset($cookie)) {
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
        return $graphObject->id;
    }

    public function processCookie() {
        $cookie = $this->getLoginCookie();

        if ($cookie === FALSE) {
            return new Result(false, "Cookie not found");
        } else {
            $user = User::findUserIdByCookie($cookie);
            if ($user === FALSE) {
                return new Result(false, "Invalid cookie");
            } else {
                return new Result(true, "");

                // set global fields
                $userID = User::findUserIdByCookie($cookie);
                $token = User::findFacebookIdByCookie($cookie);

                App::setLoggedIn($userID, $token);
            }
        }
    }

	public function processToken() {
        // initialize facebook app
		FacebookSession::setDefaultApplication('783258861766530', '20433de1149ff2619a5a681f25ea74ea');

        if (isset(App::getInput()->token)) {
            $token = strip_tags(htmlspecialchars(App::getInput()->token));

            if ($this->validateAccessToken($token)) {
                // Sign in the user by generating random cookie
                $cookie = base64_encode(openssl_random_pseudo_bytes(32));
                $existing_cookie = User::findCookieByFacebookId($token);
                // is there already a cookie allotted to the user?
                if ($existing_cookie !== FALSE) {
                    // cookie on iOS side probably expired
                    $user = new User($existing_cookie);
                    // update cookie
                    $user->setCookie($cookie);
                    // retrieve userID (using new cookie now)
                    $userID = User::findUserIdByCookie($cookie);
                } else {
                    // encountered new user. create it.
                    $userID = $this->getUserIdFromFacebook($token);
                    $user = User::createUser($userID, $cookie, $token);
                }
                // tell client to use our newest cookie
                $this->setLoginCookie($cookie);

                // set global fields
                App::setLoggedIn($userID, $token);

                return new Result(true, "Logged in");
            } else {
                return new Result(false, "Invalid token");
            }
        } else {
            return new Result(false, "Invalid payload: " . print_r(App::getInput(), TRUE));
        }
	}

}
