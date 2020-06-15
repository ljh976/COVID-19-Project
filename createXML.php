<?php
	//$stateName = $_GET["stateName"];
		
	function pullJsonData($json_url) {
		//get data from url into json format
		
		//$json = @file_get_contents($json_url);
		
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		$json = file_get_contents($json_url, false, $context);
		
		if ($json == false) {
			echo "Sorry, no data found.";
			return;
		}
		$json=str_replace('},

		]',"}

		]",$json);
		$data = json_decode($json);
		
		return $data;
	}
	
	function parseToXML($htmlStr)
	{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
	}
	
	//db part//
	require 'connectDB.php';
	$sql = 'SELECT * FROM Testing_Locations';
	if ($result = $conn->query($sql)) {
		//echo "Found all data";
	}
	else {
		//echo "Error: could not find data";
	}
	if ($result->num_rows == 0) {
		//echo "No results";
	}
	

	

	
	// Start XML file, echo parent node
	$xml = "<?xml version='1.0' ?>";
	$xml .= '<markers>';
	$ind=0;
	// Iterate through the data[$i]s, printing XML nodes for each
	 //echo(count(us_states));
	
	

	

		while($row = $result->fetch_assoc()) {
			// Add to XML document node
			//sum address in format of [address, city, state, zip-code]
			$address = ($row["address"]) . ' ' .
				($row["city"]) . ', ' . 
				($row["state"]) . ', ' . 
				($row["postal_code"]);
			//marker
			
			$xml .= '<marker ';
			$xml .= 'id="' . $ind . '" ';
			$xml .= 'id_instate="' . $row["id_instate"] . '" ';
			$xml .= 'name="' . parseToXML($row["name"]) . '" ';
			$xml .= 'address="' . parseToXML($address) . '" '; 
			$xml .= 'state="' . parseToXML($row["state"]) . '" ';
			$xml .= 'lat="' . $row["lat"] . '" ';
			$xml .= 'lng="' . $row["lng"] . '" ';
			$xml .= 'type="' . "Testing_Locations" . '" ';
			$xml .= '/>';
			$ind = $ind + 1;
			
			//if ($ind > 65) 
				//break;
		}
	
	
	// End XML file
	$xml .= '</markers>';
	header('Content-type: text/xml');
	echo($xml);
	
	//include 'getLocation.php';
	
?>


