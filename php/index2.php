<?php
    include_once 'markers.php';

    $lat = $_REQUEST['lat'];
    $lng = $_REQUEST['lng'];
    $miles = $_REQUEST['miles'] == null ? 10 : $_REQUEST['miles'];


   $markers = new markers();
   $results = $markers->getAllWithinDistance($lat, $lng, $miles);
   $resArray = array();

   $counter = 0;
   foreach ($results as $row){

		$marker->id 		= $row['_id'];
		$marker->markernum 	= $row['markernum'];
		$marker->Latitude 	= $row['Latitude'];
		$marker->Longitude 	= $row['Longitude'];
		$marker->title 		= $row['title'];
		$marker->description= $row['markertext'];
		$marker->loc_desc   = $row['loc_desc'];
		$marker->city		= $row['city'];

        $resArray[$counter++] = clone $marker;
   }

   echo $_GET['callback'] . '(' . json_encode($resArray) . ')';

//	{"queryString":"select * from historical_markers where Latitude between 30.2614717 and 30.3717097 and Longitude between -97.7318182 and -97.6215802","_id":null,"markernum":null,"atlas_number":null,"title":null,"indexname":null,"address":null,"city":null,"county":null,"utm_zone":null,"utm_east":null,"utm_north":null,"code":null,"year":null,"rthl":null,"htc":null,"loc_desc":null,"size":null,"repaircom":null,"repairdate":null,"comments":null,"markertext":null,"rthlcond":null,"Latitude":null,"Longitude":null},
// select _id,  title, markertext, atlas_number, address, city, county, year, Latitude, Longitude, loc_desc from historical_markers
?>