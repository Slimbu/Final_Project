<?php
include('Includes/connection.php');
session_start();
if(!isset($_GET['uid'])) {
	header('Location:index.php');
}

if(!isset($_SESSION['user_id'])) {
	header("location:login.php");
}

$user_id = base64_decode($_GET['uid']);

$query = "SELECT * FROM login WHERE user_id = '".$user_id."'  LIMIT 1";
	$statement = $conn -> prepare($query);
	$statement -> execute();
	$result = $statement -> fetchAll();

foreach($result as $row) {
	if($row["user_id"] >  $_SESSION['user_id']) {
		$room = $row["user_id"].$_SESSION['user_id'];
	}
	else
	{
 	$room = $_SESSION['user_id'].$row["user_id"] ;
	}
}
?>

<html lang="en">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1" />

<title>Video Chat</title>

</head>
<body>

	<iframe src="https://tokbox.com/embed/embed/ot-embed.js?embedId=c655cc60-1d60-4606-ad4e-dabc3cd8c2ea&room=<?php echo $room; ?>&iframe=true" width="100%" height="800px;" scrolling="auto" allow="microphone; camera" ></iframe>

</body>
</html>
