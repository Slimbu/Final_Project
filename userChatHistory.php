<?php

include('Includes/connection.php');
session_start();
echo get_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $conn);
?>
