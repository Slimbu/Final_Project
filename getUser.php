<?php

include('Includes/connection.php');
session_start();
$query = "SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."'";

$statement = $conn -> prepare($query);
$statement -> execute();
$result = $statement -> fetchAll();
$output = '<table class="table table-bordered table-hover table-dark">
						<tr>
              <th width="3%">Users</th>
							<th width="35%">Username</td>
							<th width="5%">Status</td>
							<th width="10%">Action</td>
						</tr>';

$countUsers = 0;
foreach($result as $row) {
	$status = '';
	if($row['log_state'] == 2) {
		$status = '<span class="label label-success">Online</span>';
	}	else {
		$status = '<span class="label label-danger">Offline</span>';
	}
  $countUsers = $countUsers + 1;
	$output .= '<tr>
                <td>'.$countUsers.'</td>
								<td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $conn).' '.fetch_is_type_status($row['user_id'], $conn).'</td>
								<td>'.$status.'</td>
								<td>

								<button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button>
								<a href="https://tokbox.com/embed/embed/ot-embed.js?embedId=c655cc60-1d60-4606-ad4e-dabc3cd8c2ea&room=DEFAULT_ROOM&iframe=true'.base64_encode($row["user_id"]).'" >Video chat</a>
								</td>
							</tr>';
}

$output .= '</table></div>';
echo $output;
?>
