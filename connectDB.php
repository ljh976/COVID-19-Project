<?php
	//info removed 
	$servername = "";
	$username = "";
	$password = "";
	$dbname = "";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	//echo "Connected successfully <br>";
	/*
	// sql to create table
	$sql = "CREATE TABLE Testing_Locations (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_instate int(6),
	name VARCHAR(100) NOT NULL,
	address VARCHAR(50),
	city VARCHAR(50),
	state VARCHAR(2),
	postal_code VARCHAR(10),
	phone VARCHAR(30),
	lat VARCHAR(50),
	lng VARCHAR(50)
	)";
	
	if ($conn->query($sql) === TRUE) {
	 // echo "Table Testing_Locations created successfully";
	} else {
	  echo "Error creating table: " . $conn->error . "<br>";
	}*/
	
	function disconnectDB() {
		global $conn;
		$conn->close();
	}
	
?>