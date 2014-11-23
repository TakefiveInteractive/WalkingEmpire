<?php

namespace WalkingEmpire;

use \WalkingEmpire\Login\Result;

class LocationInfo {
    public $latitude;
    public $longitude;

    public function __construct($lat, $lon) {
        $this->latitude = $lat;
        $this->longitude = $lon;
    }
}

class OtherUserLocationsResponse extends \WalkingEmpire\Login\Result {
    public $users;

    public function __construct($success, $users) {
        parent::__construct($success);
        $this->users = $users;
    }
}

class UserManager {

    private $input;

    public function __construct() {
        $this->input = App::getInput();
    }

    public function updateLocation() {
        // verify inputs
        if (!Util\Coord::hasLatLon($this->input))
            return new Result(false, "No location information.");
        // create User instance
        $user = new User(App::getCookie());
        $user->setLocation($this->input->longitude, $this->input->latitude);
    }

    public function getOtherUserLocations() {
        $allUsers = User::getAllUsers();
        if ($allUsers === FALSE)
            return new \WalkingEmpire\Login\Result(false, "Unable to get users.");
        $thisId = App::getUserID();

        $returnArr = array();
        $size = count($allUsers);
        for ($i = 0; $i < $size; $i++) {
            // eliminate our user from results
            if ($allUsers[$i]->getUsername() === $thisId) continue;
            // add to the array to be returned
            $location = $allUsers[$i]->getLocation();
            $returnArr[$allUsers[$i]->getUsername()] = new LocationInfo($location['latitude'], $location['longitude']);
        }
        
        $returnClass = new OtherUserLocationsResponse(true, $returnArr);
        return $returnClass;
    }
}
