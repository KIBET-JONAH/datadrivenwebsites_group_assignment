<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>

	<ul class="nav nav-tabs nav-justified bg-light sticky-top">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
		<li class="nav-item"><a class="nav-link" href="sign_up.php">Register</a></li>
		<li class="nav-item"><?php
		if((isset($_SESSION['user_id'])) && (!strpos($_SERVER['PHP_SELF'], 'sign_out.php'))) {
			echo '<a class="nav-link" href="sign_out.php">Sign Out</a>';
		}
		else {
			echo '<a class="nav-link" href="sign_in.php">Sign In</a>';
		}
		?></li>
    </ul>
	
	<br>
