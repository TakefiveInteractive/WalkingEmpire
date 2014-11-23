<?

namespace WalkingEmpire\Util;

class Coord {

    public static function hasLatLon($input) {
        return property_exists($this->input, "latitude") && property_exists($this->input, "longitude");
    }

}
