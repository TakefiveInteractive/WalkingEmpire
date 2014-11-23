<?php

namespace WalkingEmpire;

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
}
