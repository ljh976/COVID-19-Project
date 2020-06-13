 <?php
	//$stateName = $_GET["stateName"];
	include("getDetails.php");
 ?>
 <html>
  <head>
	<title> Results </title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <style>
		
		.header {
		  background-color: #500000;
		  color: #ffffff;
		  padding: 15px;
		}

		  /* Always set the map height explicitly to define the size of the div
		   * element that contains the map. */
		  #map {
			height: 85%;
		  }
			  
		  
		  [class*="col-"] {
			  float: left;
			  padding: 15px;
			}
		
			.row::after {
			  content: "";
			  clear: both;
			  display: block;
			}

			/* For desktop: */
			.col-1 {width: 8.33%;}
			.col-2 {width: 16.66%;}
			.col-3 {width: 25%;}
			.col-4 {width: 33.33%;}
			.col-5 {width: 41.66%;}
			.col-6 {width: 50%;}
			.col-7 {width: 58.33%;}
			.col-8 {width: 66.66%;}
			.col-9 {width: 75%;}
			.col-10 {width: 83.33%;}
			.col-11 {width: 91.66%;}
			.col-12 {width: 100%;}
			
			@media only screen and (max-width: 680px) {
			  /* For mobile phones: */
			  [class*="col-"] {
				width: 100%;
				height: 50%;
				padding: 0;
			  }
		}
		html, body {
        height: 100%;
        margin: 0;
        padding: 0;
		}
		.map {
			padding: 10;
			height: 100%;
			width: 100%;

			border: 2px solid;
			padding: 10px;
			box-shadow: 1px 5px #d1cdcd;
			
		.gm-style-pbc{
			display: none !important
		}
	}
    </style>
	<div class="header" style="text-align:center; font-size:20"> COVID-19 Testing Locations </div>
  </head>

  <body>
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script>
			
	
	/*
	//call json of state locations
	var myArr;
	var temp_state = "";
	var temp_lat = 0.000; // default value
	var temp_lon = 0.000; // default value
	
	console.log(temp_lat);
	console.log(temp_lon);

	
		$.getJSON("statesLocations.json", function(json) {
			myArr = json; 
			dataReady(myArr);
		})
		.done(function() {
			console.log( "json completed" );
		})
		.fail(function() {
			console.log( "json error" );
		})
		.always(function(json) {
			myArr = json
			dataReady(myArr);
		});
	console.log(temp_lat);
	console.log(temp_lon);
	function dataReady(myArr) { //set data
		temp = "";
		//console.log(myArr.length);
		for(i = 0; i < myArr.length; i++) { //find state and assign value in temps
			temp = myArr[i].state.toLowerCase().replace(' ', '-'); //temp iterate by i
			if (temp === "<?php echo $stateName ?>") { //find temp == paramerter
				
				temp_lat = myArr[i].latitude;
				temp_lon = myArr[i].longitude;
				temp_state = myArr[i].state;
				
				break;
			}
		}
	}
		
console.log(temp_lat);
	console.log(temp_lon);*/
		var customLabel = {
			restaurant: {
			label: 'R'
		},
		bar: {
			label: 'B'
			}
		};

		
		
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(41.454969, -105.623893),
          zoom: 4
        });
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
		  
          downloadUrl('<?php echo "createXML.php"; ?>', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('name');
              var address = markerElem.getAttribute('address');
              var type = markerElem.getAttribute('type');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));
			  //start pop-up code from markers
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              //text-address
			  var text = document.createElement('text');
              text.textContent = address;
			  text.appendChild(document.createElement('br'));
              infowincontent.appendChild(text);
			  
			  var link = document.createElement('div');
			  link.setAttribute('class', 'view-link');
			  var a = document.createElement('a'); //link
			  a.setAttribute("href", "http://maps.google.com/?q="+name +"," +address);
			  var span = document.createElement('span');
			  span.textContent = "View on Google Map";
			  span.appendChild(document.createElement('br'));
			  
			  var a2 = document.createElement('a');
			  
			  var state = markerElem.getAttribute("state");
			  var id_instate = markerElem.getAttribute("id_instate");
			  
			  a2.setAttribute("href", "detailsPage.php?stateName=" + state + "&id=" + id_instate);
			  var span2 = document.createElement('span');
			  span2.textContent = "See Details";
			  
			  a2.appendChild(span2);
			  a.appendChild(span);
			  link.appendChild(a);
			  link.appendChild(a2);
			  infowincontent.appendChild(link);
			 
			  //var image = 'http://coronavirus-testing-locations.com/2937253.png';
              var icon = customLabel[type] || {};
			  //marker on the map part
              var marker = new google.maps.Marker({
                map: map,
                position: point,
				animation: google.maps.Animation.DROP,
                label: icon.label,
				/* add it after find a good icon
				icon: {
					size: new google.maps.Size(20, 20),
					scaledSize: new google.maps.Size(20, 20),
					url: image
				}*/
              });

              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });

			map.addListener('center_changed', function() {
			  // 3 seconds after the center of the map has changed, pan back to the
			  // marker.
			  /*window.setTimeout(function() {
				map.panTo(marker.getPosition());
			  }, 3000);*/
			});

			 marker.addListener('click', function() {
			  map.setZoom(15);
			  map.setCenter(marker.getPosition());
			});  
			 
            });
          });
        }


      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }
      function doNothing() {}
    
	
	
	</script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=&callback&callback=initMap">
    </script>
	
	
	
	
	<?php
/*for graph... touch it later
	//to bring data for covid-19 chart
		echo "<h1 align='center' style=\"font-family: Times New Roman\";>";
		//$stateName = $_GET["stateName"];
		//echo strtoupper($stateName) . ", " . convertState($stateName) . ".</h1>";
		function change_date($date) {
			
			$date = $date[0] . $date[1] . $date[2] . $date[3] . '-' . //year part
					$date[4] . $date[5] . '-' . //month part
					$date[6] . $date[7];
					
			return $date;
		}
		
		$stateName = $_GET["stateName"];
		$json_url = 'https://covidtracking.com/api/states/daily?state=' . $stateName;
		
		//$json = file_get_contents($json_url);
		$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
		$json = file_get_contents($json_url, false, $context);
		$json=str_replace('},

		]',"}

		]",$json);
		$data = json_decode($json);
		 
		 
		$dataPoints = array(array("date", "positives"));
		
		
		$dataLength = count($data);
		//echo convertState($stateName);
		for ($x = 0; $x < $dataLength; $x++) {
			if ($data[$x]->state == convertState($stateName)) {
				#print_r ($data[$x]);
				array_push($dataPoints, array("date" => change_date((string)$data[$x]->date), "positives" => $data[$x]->positive));
				$x = $x+55; //based on the json file, it stored states in alphabetical order as a set. So this will help to accelerate this process by skipping.
				
			}
			if (count($dataPoints) > 7) {
				break;
			}
		}
		//$data1 = $dataPoints[0]['date']);
	
		$dataPoints = array_reverse($dataPoints);
*/
	?> 
  <!--
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
	  
    function drawChart() {
		var a = toString(<?php echo $dataPoints[1]['date'] ?>);

        var data = google.visualization.arrayToDataTable([
          ['Year', 'Positives'],
          [(<?php echo json_encode($dataPoints[1]['date']) ?>),  <?php echo $dataPoints[1]['positives']; ?>],
          [(<?php echo json_encode($dataPoints[2]['date']) ?>),  <?php echo $dataPoints[2]['positives']; ?>],
          [(<?php echo json_encode($dataPoints[3]['date']) ?>),  <?php echo $dataPoints[3]['positives']; ?>],
          [(<?php echo json_encode($dataPoints[4]['date']) ?>),  <?php echo $dataPoints[4]['positives']; ?>],
		  [(<?php echo json_encode($dataPoints[5]['date']) ?>),  <?php echo $dataPoints[5]['positives']; ?>],
		  [(<?php echo json_encode($dataPoints[6]['date']) ?>),  <?php echo $dataPoints[6]['positives']; ?>]
        ]);

        var options = {
          title: 'COVID-19 DAILY STATUS',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  -->
  
	<!--<div class="row">
		<div class="col-6">
			
			<p style="text-align: right;"> If above map does not work properly, please try to refresh this page (press F5) </p>
		</div>
		<div class="col-5">
			<div id="curve_chart"
			style="font-family: Times New Roman";"></div>
			<div>
				<?php 
					include_once 'getDetails.php';
					//printAllHosLocaions($_GET["stateName"]);
				?>
			</div>
		</div>
		
	</div>-->
	<div class="map" id="map"></div>

  </body>
  <footer>
  
  <p align='right' style="font-family: Times New Roman"> 
  This is a test version.<br>
  For any issue or concern, please contact me via email: ljh976@tamu.edu.<br>
  Data Proviers: The COVID Tracking Project, Postman. <br>
  Thank you and stay healthy.</p>
  </footer>
</html>
