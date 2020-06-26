<?php

	require 'getDetails.php';
	printTestLocations(strtolower(convertState($_GET['stateName'])), $_GET['id']-1);
?>