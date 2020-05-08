<?php
session_start();
include('Includes/connection.php');

$sql2="update login set log_state = '1' where username='".$_SESSION['username']."'  ";
$statement2 = $conn -> prepare($sql2);
$statement2 -> execute();
session_destroy();
header("Location:login.php");
?>
