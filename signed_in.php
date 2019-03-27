<?php
session_start();

//If user is not logged in redirect him to the login page
if (!isset($_SESSION ['user_id'])) {
	
	header ( 'location: sign_in.php' );
}

$title = 'Signed_in.php';
include_once 'header.php';


echo"
<h1 style='color: green; text-align: center;'>Hello {$_SESSION
['first_name']}! You have successfully signed in</h1>

";

include_once 'footer.php';

?>