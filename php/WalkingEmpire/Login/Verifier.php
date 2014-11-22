<?php

namespace WalkingEmpire\Login;

class Result {
    
}

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

	function process() {
		// initialize facebook app
		FacebookSession::setDefaultApplication('783258861766530', '20433de1149ff2619a5a681f25ea74ea');

        if (!isset($_POST['token'])) {
            if (validateAccessToken(strip_tags($_POST['token']))) {
            } else {
            }
        } else {
            return false;
        }
	}

}
