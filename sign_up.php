<?php

$title = 'Sign Up';
include_once 'header.php';

$errors = array();

if(isset($_POST['sign_up'])) {
	
	//php script for connecting to the database
	include_once 'db_connect.php';
	
	//Initialize the error array
	//$errors = array();
	
	//Validate First Name
	if(!empty($_POST['fname'])) {
		$first_name = sanitizeString($conn, $_POST['fname']);
	}
	else {
		$errors[] = "You forgot to enter your first name";
	}
	
	//Validate Last Name
	if(!empty($_POST['lname'])) {
		$last_name = sanitizeString($conn, $_POST['lname']);
	}
	else {
		$errors[] = "You forgot to enter your last name";
	}
	
	//Validate email
	if(!empty($_POST['email'])){
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$email = sanitizeString($conn, $_POST['email']);
		}
		else {
			$errors[] = "Invalid email address";
		}
	}
	else {
		$errors[] = "You forgot to enter your email address";
	}
	
	//Password validation and matching
	if(!empty($_POST['pass'])){
		if($_POST['pass'] == $_POST['confirm_pass']) {
			if(strlen($_POST['pass']) >= 6) {
				$password = sanitizeString($conn, $_POST['pass']);
			}
			else {
				$errors[] = "Your passwords is less than 6 characters";
			}
		}
		else {
			$errors[] = "Your passwords do not match";
		}
	}
	else {
		$errors[] = "You forgot to enter your password";
	}
	
	//If there are no errors process user input
	if(empty($errors)) {
		//Check if user is already registered
		$query = "SELECT * FROM registered_users WHERE email='$email'";
		$result = $conn->query($query);
		$rows = $result->num_rows;
		if($rows == 0) {
			//If user does not exist register the user
			$query1 = "INSERT INTO registered_users(fname, lname, email, password)
			VALUES('$first_name', '$last_name', '$email', md5('$password'))";
			$result1 = $conn->query($query1);
			if($result1) {
				echo "<b style='color: green;'>$first_name, You have successfully registered!</b>";
			}
			else {
				echo "<b>Registration not successful!!</b>";
			}
		}
		else {
			echo "<b>Your email has already been used</b>";
		}
		
		//Close database connection
		mysqli_close($conn);
	}
	//If there are errors process it
	else {
		//Process the errors
		foreach($errors as $error){
			echo "<b>$error</b><br>";
		}
	}

}
/**
 * Function to remove special characters and prevent XSS attacks and SQL Injection
 */
function sanitizeString($conn, $string) {
    $string = strip_tags($string);
    $string = stripcslashes($string);
    return $conn->real_escape_string($string);
}

?>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">User Registration</div>
        <div class="card-body">
            <form action="sign_up.php" method="post">
                <div class="form-group row">
                    <label for="fname" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-md-6">
                    <input type="text" name="fname" id="fname" class="form-control"
					placeholder="example: John">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="lname" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-md-6">
                    <input type="text" name="lname" id="lname" class="form-control"
					placeholder="example: Smith">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-md-6">
                    <input type="email" name="email" id="email" class="form-control"
                     placeholder="example@mail.com">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pass" class="col-sm-3 col-form-label">Password</label>
                    <div class="col-md-6">
                    <input type="password" name="pass" id="pass" class="form-control"
					placeholder="password more than 6 characters">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="confirm_pass" class="col-sm-3 col-form-label">Confirm Password</label>
                    <div class="col-md-6">
                    <input type="password" name="confirm_pass" id="confirm_pass" class="form-control"
					placeholder="same password as above">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label"></label>
                    <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" name="sign_up" value="Sign Up">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>
