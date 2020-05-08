<?php

include('Includes/connection.php');
session_start();
$data = array(':to_user_id' => $_POST['to_user_id'], ':senderUserID' => $_SESSION['user_id'], ':chat_message'	=> $_POST['chat_message'], ':status' =>	'1');
$query = "INSERT INTO chat_message(to_user_id, senderUserID, chat_message, status) VALUES (:to_user_id, :senderUserID, :chat_message, :status)";
$statement = $conn -> prepare($query);
if ($statement -> execute($data)) {
  echo get_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $conn);
}
