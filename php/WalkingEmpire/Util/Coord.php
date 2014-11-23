<?php

namespace WalkingEmpire\Util;

class Coord {

    public static function hasLatLon($input) {
        return property_exists($input, "latitude") && property_exists($input, "longitude");
    }

}
