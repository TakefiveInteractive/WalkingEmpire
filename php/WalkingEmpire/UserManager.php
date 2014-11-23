<?php

namespace WalkingEmpire;

class LocationInfo {
    public $latitude;
    public $longitude;

    public function __construct($lat, $lon) {
        $this->latitude = $lat;
        $this->longitude = $lon;
    }
}

class UserManager {

    private $input;

    public function __construct() {
        $this->input = App::getInput();
    }

    public function updateLocation() {
        if (!Util\Coord::hasLatLon($this->input))
            return new Result(false, "No location information.");
        // create User instance
        $user = new User(App::getCookie());
        $user->setLocation($this->longitude, $this->latitude);
    }

    public function getOtherUserLocations() {
        $allUsers = User::getAllUsers();
        $thisId = App::getUserID();

        $returnArr = array();
        $size = count($allUsers);
        for ($i = 0; $i < $size; $i++) {
            // skip our user
            if ($allUsers[$i]->getUsername() === $thisId) continue;
            // add to the array to be returned
            $location = $allUsers[$i]->getLocation();
            $returnArr[$allUsers[$i]->getToken()] = new LocationInfo($location['latitude'], $location['longitude']);
        }
        return $returnArr;
    }
}
