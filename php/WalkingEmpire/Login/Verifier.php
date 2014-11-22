<?php

namespace WalkingEmpire\Login;

use Facebook\FacebookSession;
use WalkingEmpire\User;
use WalkingEmpire\App;

/**
 * JSON class representing login result
 */
class Result {

    public $success;

    public $comment;

    function __construct($success, $comment = "None") {
        $this->success = $success;
        $this->comment = $comment;
    }
}

class Verifier {

	function __construct() {
        // initialize facebook app
		FacebookSession::setDefaultApplication('783258861766530', '20433de1149ff2619a5a681f25ea74ea');
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
        setcookie(self::LOGIN_COOKIE_NAME, $cookie_val);
    }

    function getLoginCookie() {
        if (isset($_COOKIE[self::LOGIN_COOKIE_NAME])) {
            return $_COOKIE[self::LOGIN_COOKIE_NAME];
        } else {
            return FALSE;
        }
    }

    function processCookie() {
        $cookie = getLoginCookie();

        if ($cookie === FALSE) {
            return new Result(false, "Cookie not found");
        } else {
            $user = User::findUserIdByCookie($cookie);
            if ($user === FALSE) {
                return new Result(false, "Invalid cookie");
            } else {
                return new Result(true, "Logged in");
            }
        }
    }

	function processToken() {
        if (isset(App::getInput()->token)) {
            $token = strip_tags(htmlspecialchars(App::getInput()->token));

            if ($this->validateAccessToken($token)) {
                // Sign in the user by generating random cookie
                $cookie = base64_encode(openssl_random_pseudo_bytes(32));
                $existing_cookie = User::findCookiieByFacebookId($token);
                // is there already a cookie allotted to the user?
                if ($existing_cookie !== FALSE) {
                    // cookie on iOS side probably expired
                    $user = new User($existing_cookie);
                    // update cookie
                    $user->setCookie($cookie);
                } else {
                    // new user
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
                    $userID = $graphObject->id;

                    $user = User::createUser($userID, $cookie, $token);
                }
                // tell client the newest cookie
                $this->setLoginCookie($cookie);
                return new Result(true, "Logged in");
            } else {
                return new Result(false, "Invalid token");
            }
        } else {
            return new Result(false, "Invalid payload");
        }
	}

}
