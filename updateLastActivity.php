<?php

include('Includes/connection.php');
session_start();
$query = "UPDATE login_details SET last_status = now() WHERE login_details_id = '".$_SESSION["login_details_id"]."'";
$statement = $conn -> prepare($query);
$statement -> execute();
?>
