<?php

echo '<style>';
echo '#hospitals {';
echo 'font-family: "Times New Roman", Times, serif;';
echo 'border-collapse: collapse;';
echo 'width: 100%;';
echo '}';
echo '';
echo '#hospitals td, #hospitals th {';
echo 'border: 1px solid #ddd;';
echo 'padding: 8px;';
echo '}';
echo '';
echo '#hospitals tr:nth-child(even){background-color: #f2f2f2;}';
echo '';
echo '#hospitals tr:hover {background-color: #ddd;}';
echo '';
echo '#hospitals th {';
echo 'padding-top: 12px;';
echo 'padding-bottom: 12px;';
echo 'text-align: left;';
echo 'background-color: #500000;';
echo 'color: white;';
echo '}';
echo '</style>';



function printTestLocations($stateName, $x) {
	$json_url = 'https://covid-19-testing.github.io/locations/' . $stateName . '/complete.json';
	
	$json = @file_get_contents($json_url);
	if ($json == false) {
		echo "Sorry, no data found.";
		return;
	}
	$json=str_replace('},

	]',"}

	]",$json);
	$data = json_decode($json);
	echo "<h3 style=\"font-family: Times New Roman\";>List of COVID-19 Test Providers: </h3>";
	echo '<table id="hospitals">';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Contact</th>';
	echo '<th>Address</th>';
	echo '<th>Map</th>';
	echo '<th>Business Hours</th>';
	echo '</tr>';
	
	$monDaytoFriday = array("MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN");

	//for ($x = 0; $x < count($data); $x++) {
		echo '<tr>';
		echo '<td>' . @($data[$x]->name) . '</td>'; //name of the place
		#print_r(@($data[$x]->phones[$x]));
		echo '<td>' . @($data[$x]->phones[0]->number) . '</td>'; //phone
		if (isset($data[$x]->physical_address[0])) { //if address exists
			echo '<td>' . @($data[$x]->physical_address[0]->address_1) . '<br>' . 
			@($data[$x]->physical_address[0]->city) . ', ' . 
			@($data[$x]->physical_address[0]->state_province) . 
			', ' . @($data[$x]->physical_address[0]->postal_code) . '</td>'; //address
			
			echo '<td><a href="http://maps.google.com/?q=' . 
			@$data[$x]->name . ', ' . 
			$data[$x]->physical_address[0]->address_1 . ' ' .
			$data[$x]->physical_address[0]->city . ', ' . 
			$data[$x]->physical_address[0]->state_province .  ', ' . 
			$data[$x]->physical_address[0]->postal_code . 
			'">' . ' Map' . '</a>' . '</td>'; //display google map with the locations by addresses
		}
		else {
			echo '<td>TBA</td>';
			echo '<td><a href="http://maps.google.com/?q=' . @$data[$x]->name . '">' . ' Map' . '</a>' . '</td>'; //display google map with the locations by names
		}
			echo '<td>'; 
			for ($y = 0; $y < count($data[$x]->regular_schedule); $y++) {
				if ($data[$x]->regular_schedule[$y]) {
					echo $monDaytoFriday[$data[$x]->regular_schedule[$y]->weekday-1] . ': '. $data[$x]->regular_schedule[0]->opens_at . ' - ' . $data[$x]->regular_schedule[0]->closes_at . '<br>';
				}
			}
			echo '</td>';
		echo '</tr>';
	//}
	echo '</table>';
	
};
function convertState($name) {
   $states = array(
      array('name'=>'Alabama', 'abbr'=>'AL'),
      array('name'=>'Alaska', 'abbr'=>'AK'),
      array('name'=>'Arizona', 'abbr'=>'AZ'),
      array('name'=>'Arkansas', 'abbr'=>'AR'),
      array('name'=>'California', 'abbr'=>'CA'),
      array('name'=>'Colorado', 'abbr'=>'CO'),
      array('name'=>'Connecticut', 'abbr'=>'CT'),
      array('name'=>'Delaware', 'abbr'=>'DE'),
      array('name'=>'Florida', 'abbr'=>'FL'),
      array('name'=>'Georgia', 'abbr'=>'GA'),
      array('name'=>'Hawaii', 'abbr'=>'HI'),
      array('name'=>'Idaho', 'abbr'=>'ID'),
      array('name'=>'Illinois', 'abbr'=>'IL'),
      array('name'=>'Indiana', 'abbr'=>'IN'),
      array('name'=>'Iowa', 'abbr'=>'IA'),
      array('name'=>'Kansas', 'abbr'=>'KS'),
      array('name'=>'Kentucky', 'abbr'=>'KY'),
      array('name'=>'Louisiana', 'abbr'=>'LA'),
      array('name'=>'Maine', 'abbr'=>'ME'),
      array('name'=>'Maryland', 'abbr'=>'MD'),
      array('name'=>'Massachusetts', 'abbr'=>'MA'),
      array('name'=>'Michigan', 'abbr'=>'MI'),
      array('name'=>'Minnesota', 'abbr'=>'MN'),
      array('name'=>'Mississippi', 'abbr'=>'MS'),
      array('name'=>'Missouri', 'abbr'=>'MO'),
      array('name'=>'Montana', 'abbr'=>'MT'),
      array('name'=>'Nebraska', 'abbr'=>'NE'),
      array('name'=>'Nevada', 'abbr'=>'NV'),
      array('name'=>'New-Hampshire', 'abbr'=>'NH'),
      array('name'=>'New-Jersey', 'abbr'=>'NJ'),
      array('name'=>'New-Mexico', 'abbr'=>'NM'),
      array('name'=>'New-York', 'abbr'=>'NY'),
      array('name'=>'North-Carolina', 'abbr'=>'NC'),
      array('name'=>'North-Dakota', 'abbr'=>'ND'),
      array('name'=>'Ohio', 'abbr'=>'OH'),
      array('name'=>'Oklahoma', 'abbr'=>'OK'),
      array('name'=>'Oregon', 'abbr'=>'OR'),
      array('name'=>'Pennsylvania', 'abbr'=>'PA'),
      array('name'=>'Rhode-Island', 'abbr'=>'RI'),
      array('name'=>'South-Carolina', 'abbr'=>'SC'),
      array('name'=>'South-Dakota', 'abbr'=>'SD'),
      array('name'=>'Tennessee', 'abbr'=>'TN'),
      array('name'=>'Texas', 'abbr'=>'TX'),
      array('name'=>'Utah', 'abbr'=>'UT'),
      array('name'=>'Vermont', 'abbr'=>'VT'),
      array('name'=>'Virginia', 'abbr'=>'VA'),
      array('name'=>'Washington', 'abbr'=>'WA'),
      array('name'=>'West Virginia', 'abbr'=>'WV'),
      array('name'=>'Wisconsin', 'abbr'=>'WI'),
      array('name'=>'Wyoming', 'abbr'=>'WY'),
      array('name'=>'Virgin Islands', 'abbr'=>'V.I.'),
      array('name'=>'Guam', 'abbr'=>'GU'),
      array('name'=>'Puerto Rico', 'abbr'=>'PR')
   );

   $return = false;   
   $strlen = strlen($name);

   foreach ($states as $state) :
      if ($strlen < 2) {
         return false;
      } else if ($strlen == 2) {
         if (strtolower($state['abbr']) == strtolower($name)) {
            $return = $state['name'];
            break;
         }   
      } else {
         if (strtolower($state['name']) == strtolower($name)) {
            $return = strtoupper($state['abbr']);
            break;
         }         
      }
   endforeach;
   
   return $return;
} // end function convertState()
	


function printAllHosLocaions($stateName) {
	
	 //list of hospitals 
	$json_url = 'https://postman-data-api-templates.github.io/county-health-departments/api/' . $stateName . '.json';
	
	$json = file_get_contents($json_url);
	$json=str_replace('},

	]',"}

	]",$json);
	$data = json_decode($json);

	echo "<h3 style=\"text-align:center \">List of Hospitals </h3> ";
	echo '<table id="hospitals">';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Contact</th>';
	echo '<th>Address</th>';
	echo '</tr>';

	for ($x = 0; $x < count($data); $x++) {
		echo '<tr>';
		echo '<td>' . @($data[$x]->name) . '</td>';
		echo '<td>' . (@$data[$x]->phone) . '</td>';
		if (isset($data[$x]->undefined)) {
			//@print_r($data[$x]->undefined);
			echo '<td>' . '<a href="http://maps.google.com/?q=' . @$data[$x]->name . '">' . @$data[$x]->undefined . '</a>' . '</td>';
		}
		if (isset($data[$x]->address)) {
			//@print_r($data[$x]->address);
			echo '<td>' . '<a href="http://maps.google.com/?q=' . @$data[$x]->name . '">' . @$data[$x]->address . '</a>' . '</td>';
		}
		echo '</tr>';
		
	}
	echo '</table>';
	
}
	
	

	
	//end of head part
	//printTestLocations($stateName); //print out testing locations from api
	//printAllHosLocaions($stateName);
	
	
?>