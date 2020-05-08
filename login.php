<?php

include('Includes/connection.php');

session_start();
$message = '';

if(isset($_SESSION['user_id'])) {
	header('Location:index.php');
}

if(isset($_POST['login'])) {
	$query = "SELECT * FROM login WHERE username = :username";
	$statement = $conn->prepare($query);
	$statement -> execute(array(':username' => $_POST["username"]));
	$count = $statement -> rowCount();
	if($count > 0) {
		$result = $statement->fetchAll();
		$sql2="update login set log_state='2' where username='".$_POST["username"]."'  ";
		$statement2 = $conn -> prepare($sql2);
		$statement2 -> execute();
		foreach($result as $row) {
			if(password_verify($_POST["password"], $row["password"])) {
				$_SESSION['user_id'] = $row['user_id'];
				$_SESSION['username'] = $row['username'];
				$sub_query = "INSERT INTO login_details(user_id) VALUES ('".$row['user_id']."')";
				$statement = $conn -> prepare($sub_query);
				$statement -> execute();
				$_SESSION['login_details_id'] = $conn -> lastInsertId();
				header('Location:index.php');
			}
			else {
				$message = "<script>alert('Password incorrect')</script>";
			}
		}
	}
	else {
		$message = "<script>alert('Username incorrect')</script>";
	}
}
?>
<html>
<head>
  <title>LOG IN PAGE</title>
	<link rel="stylesheet" href="CSS/login.css">
</head>
<body>
<div class="signin_form">
  <form action="" method="post">
		<div class="form_header">
			<h2>Log In</h2>
			<p> SHOW-LIM </p>
		</div>
		<p class="text-danger"><?php echo $message; ?></p>
		<div class="form_gorup">
			<label>Username</label>
			<input  class="form_input" type="text" name="username" placeholder="Username" autocomplete="off" required="required">
		</div>
		<div class="form_gorup">
			<label>Password</label>
			<input class="form_input" type="password" name="password" placeholder="Password" autocomplete="off" required="required">
		</div>
		<div class="form_gorup">
			<button type="submit" id="singin_button" name="login">Sign in</button>
		</div>
  </form>
	<div class="form_group">Don't have an account? <a href="signup.php">Create one</a></div>
</div>
</body>
</html>
