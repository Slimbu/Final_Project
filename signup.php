<?php

include('Includes/connection.php');
session_start();

$message = '';

if(isset($_SESSION['user_id'])) {
	header('location:index.php');
}

if(isset($_POST["register"])) {
	$username = trim($_POST["username"]);
	$password = trim($_POST["password"]);
	$check_query = "SELECT * FROM login WHERE username = :username";
	$statement = $conn -> prepare($check_query);
	$check_data = array(':username' => $username);
	if($statement -> execute($check_data)) {
		if($statement -> rowCount() > 0) {
			$message .= "<script>alert('Username already taken, please try again!')</script>";
		}
		else {
			if(empty($username)) {
				$message .= "<script>alert('Username is required, please try again!')</script>";
			}
			if(empty($password)) {
				$message .= "<script>alert('Password is required, please try again!')</script>";
			}
			else {
				if($password != $_POST['confirmPassword']) {
					$message .= "<script>alert('Password does not match, please try again!')</script>";
				}
			}
			if($message == '') {
				$data = array(':username'	=> $username, ':password' => password_hash($password, PASSWORD_DEFAULT));
				$query = "INSERT INTO login(username, password) VALUES (:username, :password)";
				$statement = $conn -> prepare($query);
				if($statement -> execute($data)) {
					echo "<script>alert('Congratulation $username, your account has been successfully created!')</script>";
					echo "<script>window.open('login.php', '_self')</script>";
				}
			}
		}
	}
}
?>
<html>
<head>
	<title>Registration Page</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="CSS/signup.css">
</head>
<body>
<div class="signin_form">
  <form action="" method="post">
		<div class="form_header">
			<h2>Registration Form</h2>
			<p>SHOW-LIM</p>
		</div>
		<p class="alert_text"><?php echo $message; ?></p>
		<div class="form_gorup">
			<label>Username</label>
			<input type="text" class="form_input" name="username" placeholder="Username" autocomplete="off" required>
		</div>
		<div class="form_gorup">
			<label>Password</label>
			<input type="password" class="form_input" name="password" placeholder="Password" autocomplete="off" required>
		</div>
    <div class="form_gorup">
			<label>Confirm-Password</label>
			<input type="password" class="form_input" name="confirmPassword" placeholder="Confirm-Password" autocomplete="off" required>
		</div>
		<div class="form_gorup">
		<button type="submit" class="btn" name="register">Sign Up</button>
		</div>
  </form>
	<div class="form_group">Already have an account? <a href="login.php">Log in here</a></div>
</div>
</body>
</html>
