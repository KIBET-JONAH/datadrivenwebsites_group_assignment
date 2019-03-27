<?php

//Variables to connect to the database
$dbhost = 'localhost';
$dbname = 'signup_login';
$dbuser = 'root';
$dbpass = '';

//make connection to the database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	//if errors occur they will be shown to the user
	if ($conn->connect_error) die ($conn->error);

?>