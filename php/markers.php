<?php
class markers {

    private $db;
    public $one_mile = .0110238;  // defines 1 mile (+/- 6 inches)

    function  __construct()
    {
        $filename = "./historical_markers.db3";
        $dsn = "sqlite:$filename";
        try {
            $db = new PDO("sqlite:$filename");
            $this->db = $db;
            if (!$db) {
                echo "<p>Error: $error_message</p>";
                echo "<p>[$dsn]</p>";
                die($error_message);
            }
        }
        catch(Exception $e){
            echo "Exception: $e->getMessage()";
            echo "dsn = $dsn<br/>";
        }
    }

    public function getAllWithinDistance($lat, $lng, $miles)
    {
            $totalmiles = $miles* $this->one_mile;
            $lowlat = $lat-$totalmiles;
            $hilat = $lat+$totalmiles;
            $lowlng = $lng-$totalmiles;
            $hilng = $lng+$totalmiles;

            $querytext = "select * from historical_markers where Latitude between ";
            $querytext .= "$lowlat and $hilat";
            $querytext .= " and Longitude between $lowlng and $hilng";

//            echo "[ " . $querytext . " ]<br/> ";
            $results = $this->db->query($querytext, SQLITE_ASSOC, $error);

            return $results;
    }

    public function distance($lat1, $lng1, $lat2, $lng2, $miles = true)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return ($miles ? ($km * 0.621371192) : $km);
    }

    public function GetAllMarkerData() {
        $querytext = "select _id, markernum, title, county, city, Latitude, Longitude from historical_markers
where atlas_number is not null";

        $results = $this->db->query($querytext, SQLITE_ASSOC, $error);

        return  $results;
    }

    public function GetMarkerMetaData() {
        $querytext = "select _id, version, rowcount from markers_metadata";
        $results = $this->db->query($querytext, SQLITE_ASSOC, $error);

        return  $results;
    }
}
?>
