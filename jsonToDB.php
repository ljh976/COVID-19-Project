<?php

set_time_limit(1000000); 

//array for states. values should be lowercases and spaces should be replaced by '-'
$stateArr = array(
		   'alabama',
		   'alaska',
		   'arizona',
		   'arkansas',
		   'california',
		   'colorado',
		   'connecticut',
		   'delaware',
		   'district of columbia',
		   'florida',
		   'georgia',
		   'hawaii',
		   'idaho',
		   'illinois',
		   'indiana',
		   'iowa',
		   'kansas',
		   'kentucky',
		   'louisiana',
		   'maine',
		   'maryland',
		   'massachusetts',
		   'michigan',
		   'minnesota',
		   'mississippi',
		   'missouri',
		   'montana',
		   'nebraska',
		   'nevada',
		   'new-hampshire',
		   'new-jersey',
		   'new-mexico',
		   'new-york',
		   'north-carolina',
		   'north-dakota',
		   'ohio',
		   'oklahoma',
		   'oregon',
		   'pennsylvania',
		   'rhode-island',
		   'south-carolina',
		   'south-dakota',
		   'tennessee',
		   'texas',
		   'utah',
		   'vermont',
		   'virginia',
		   'washington',
		   'west-virginia',
		   'wisconsin',
		   'wyoming',
		);  
	

	//must connect to db
	if (!require "connectDB.php") 
		return;
	
	//bring json from url
	function jsonFromURL($json_url) {
	//$json_url = 'https://postman-data-api-templates.github.io/county-health-departments/api/' . $stateName . '.json';
	
	$json = file_get_contents($json_url);
	$json=str_replace('},

	]',"}

	]",$json);
	$data = json_decode($json);
	
	return $data;
	}
	
	//get lat and lng in an array from google's geocode api
	function get_LatANDLong($address) {
		// Get lat and long by address         
		$api_key = "";
		$prepAddr = str_replace(' ','+',$address);
		//$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false'."&key=" . $api_key);
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false'."&key=" . $api_key, false, $context);
		$output= json_decode($geocode);
		$latitude = $output->results[0]->geometry->location->lat;
		$longitude = $output->results[0]->geometry->location->lng;
		//usleep(500000);
		return $array = array($latitude, $longitude);
	}
	
	
	
	
	

	for ($i = 0; $i < count($stateArr); $i++) {
		$json_url = 'https://covid-19-testing.github.io/locations/' . $stateArr[$i] . '/complete.json';
		$data = jsonFromURL($json_url); //assign json data from url to $data
		if (!isset($data)) { //prevent error by invaild input for url
			continue;
		}
		
		for($j = 0; $j < count($data); $j++) {
			$address =  @($data[$j]->physical_address[0]->address_1) . ' ' .
			@($data[$j]->physical_address[0]->city) . ', ' . 
			@($data[$j]->physical_address[0]->state_province) . 
			', ' . @($data[$j]->physical_address[0]->postal_code);
				
			if (isset($data[$j]->physical_address[0]))
				$latlongArr = get_LatANDLong($address);
			else
				$latlongArr = get_LatANDLong($data[$j]->name); //in case address does not exist
			
			
			$sql = "INSERT INTO Testing_Locations (name, id_instate, address, city, state, postal_code , phone, lat, lng) 
			VALUES ('". $data[$j]->name . "', '" . 
						$data[$j]->id . "', '" . 
						$data[$j]->physical_address[0]->address_1 . "', '" . 
						$data[$j]->physical_address[0]->city . "', '" .
						$data[$j]->physical_address[0]->state_province . "', '" .
						$data[$j]->physical_address[0]->postal_code . "', '" .
						$data[$j]->phones[0]->number . "', '" .
						$latlongArr[0] . "', '" .
						$latlongArr[1] . "')";
			
			if ($conn->query($sql) === TRUE) {
			  echo "<br>Data was input successfully<br>";
			} else {
			  echo "<br>Error inputting data. at address: " . $address . $conn->error . "<br>";
			}

		}
	}//end of stateArr for loop
	

	disconnectDB();
?>
