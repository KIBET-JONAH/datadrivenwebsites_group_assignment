<?php

$title = 'Sign In';
include_once 'header.php';

if(isset($_POST['signin'])) {
	
	//php script for connecting to the database
	include_once 'db_connect.php';
	
	//Initialize the error array
	$errors = array();
	
	//Validate email
	if(!empty($_POST['email'])){
		//checking if the email is valid
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
	
	//Password validation
	if(!empty($_POST['pass'])){
		if(strlen($_POST['pass']) >= 6) {
			$password = sanitizeString($conn, $_POST['pass']);
		}
		else {
			$errors[] = "Your passwords is less than 6 characters";
		}
	}
	else {
		$errors[] = "You forgot to enter your password";
	}
	
	if(empty($errors)) {
		//Check if user is exists/registered
		$query = "SELECT email FROM registered_users WHERE email='$email'";
		$result = $conn->query($query);
		$rows = $result->num_rows;
		if($rows == 1) {
			//Get the users user_id and first name from database
			$query1 = "SELECT user_id, fname FROM registered_users WHERE email='$email' 
			AND password=md5('$password')";
			$result1 = $conn->query($query1);
			$rows1= $result1->num_rows;
			if($rows1 == 1) {
				//Fetch the results
				$row = mysqli_fetch_array($result1, MYSQLI_ASSOC);
				
				//Start the session
				session_start();
				
				//Assign the session variables
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['first_name'] = $row['fname'];
				
				//Page redirected to after a successful login
				$url = 'signed_in.php';
				header("Location: $url");
			}
			else {
				echo "<b>The email address and password do not match!</b>";
			}
		}
		else {
			echo "<b>You have not registered!</b>";
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
        <div class="card-header">Login</div>
        <div class="card-body">
            <form action="" method="post">
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
                    <input type="password" name="pass" id="pass" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label"></label>
                    <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" name="signin" value="Sign in">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

include_once 'footer.php';

?>