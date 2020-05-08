<?php

include('Includes/connection.php');
session_start();

if($_POST["action"] == "insert_data") {
	$data = array(':senderUserID' => $_SESSION["user_id"], ':chat_message' => $_POST['chat_message'],':status' => '1');
	$query = "INSERT INTO chat_message(senderUserID, chat_message, status) VALUES (:senderUserID, :chat_message, :status)";
	$statement = $conn -> prepare($query);
	if($statement -> execute($data)) {
		echo fetch_group_chat_history($conn);
	}
}

if($_POST["action"] == "fetch_data") {
	echo fetch_group_chat_history($conn);
}
?>
