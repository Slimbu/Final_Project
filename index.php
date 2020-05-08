<?php

include('Includes/connection.php');
session_start();
if(!isset($_SESSION['user_id'])) {
	header("location:login.php");
}
?>
<html>
<head>
	<title>SHOW - LIM</title>

	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<link rel="stylesheet" href="CSS/index.css" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.1/css/font-awesome.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
</head>
<body>

	<nav class="navbar navbar-light" style="background-color: #05080a; border-radius: 0px">
		<div class="container-fluid">
	    <a href="#"><img src="Img/logo.png" alt="logo" height="45" width="45"></a>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#account" data-toggle="modal"><span class="glyphicon glyphicon-user"></span> My Account</a></li>
	      <li><a href="#logout" data-toggle="modal"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			</ul>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-6">
			</div>
			<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<center><h4 class="modal-title" id="myModalLabel">Are you sure you want to logout?</h4></center>
						</div>
						<div class="modal-body">
							<div class="container-fluid">
								<center><strong><span style="font-size: 25px, color: red;">Do you want to log out? <br> <hr> <?php echo $_SESSION['username']; ?></span></strong></center>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span> No </button>
							<a href="logout.php" class="btn btn-danger"><span class="glyphicon glyphicon-log-out"></span> Yes </a>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	      <div class="modal-dialog">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	            <center><h4 class="modal-title" id="myModalLabel">My Account</h4></center>
	          </div>
	         	<div class="modal-body">
							<div class="container-fluid">
								<form method="POST" action="update_account.php">
								<div style="height: 10px;"></div>
								<div class="form-group input-group">
									<span class="input-group-addon" style="width:150px;">Username:</span>
									<input  style="width:350px; text-align: center;" class="form-control" name="newUsername" value="<?php echo $_SESSION['username'];?>" >
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button>
							</form>
						</div>
					</div>
	      </div>
	    </div>

			<div>
				<input type="hidden" id="groupChatWindow" value="no" />
				<button type="button" name="group_chat" id="group_chat" class="open-button">ALL CHAT</button>
			</div>

			<div class="box">
				<button class="white" id="white"></button>
				<button class="yellow" id="yellow"></button>
				<button class="gray" id="gray"></button>
				<button class="red" id="red"></button>
				<button class="purple" id="purple"></button>
			</div>

		</div>
		<div class="table-responsive">
			<div id="user_details"></div>
				<div id="user_model_details"></div>
			</div>
		</div>
		<div id="groupChatDialog" title="Group Chat Window">
			<div id="group_chat_history" style="height: 420px; border: 1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding: 16px;">
		</div>

		<div class="form-group">
			<div class="chat_message_area">
				<div id="group_chat_message" contentEditable=true data-text="Write your message here.." class="form-control"></div>

				<div class="image_upload">
					<form id="uploadImage" method="post" action="upload.php">
						<label for="uploadFile"><img src="Img/upload.png" /></label>
						<input type="file" name="uploadFile" id="uploadFile" accept=".jpg, .png" />
					</form>
				</div>
			</div>

			<div class="form-group" align="right">
				<button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info" style="margin-top: 6px; margin-bottom: 0px;">Send</button>
			</div>

		</div>
	</div>

</body>
</html>

<script>
$(document).ready(function(){
	fetch_user();
	setInterval(function(){
		updateLastActivity();
		fetch_user();
		updateChatHistoryData();
		fetchGroupChatHistory();
	}, 3000);

	$(document).on('click', '.start_chat', function(){
		var to_user_id = $(this).data('touserid');
		var to_user_name = $(this).data('tousername');
		make_chat_dialog_box(to_user_id, to_user_name);
		$("#user_dialog_" + to_user_id).dialog({
			autoOpen:false,
			width:400
		});
		$('#user_dialog_' + to_user_id).dialog('open');
		$('#chat_message_' + to_user_id).emojioneArea({
			pickerPosition:"top",
			toneStyle: "bullet"
		});
	});

	$(document).on('click', '.send_chat', function(){
		var to_user_id = $(this).attr('id');
		var chat_message = $.trim($('#chat_message_' + to_user_id).val());
		if(chat_message != ''){
			$.ajax({
				url:"insertChat.php",
				method:"POST",
				data:{to_user_id:to_user_id, chat_message:chat_message},
				success:function(data){
					var element = $('#chat_message_' + to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#chat_history_' + to_user_id).html(data);
				}
			})
		}
		else {
			alert('Type something');
		}
	});

	$(document).on('click', '.remove_chat', function(){
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?"))
		{
			$.ajax({
				url:"deleteChat.php",
				method:"POST",
				data:{chat_message_id:chat_message_id},
				success:function(data)
				{
					update_chat_history_data();
				}
			})
		}
	});

	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#groupChatWindow').val('no');
	});

	$(document).on('focus', '.chat_message', function(){
		var is_type = 'yes';
		$.ajax({
			url:"updateTypeStatus.php",
			method:"POST",
			data:{is_type:is_type},
			success:function(){
			}
		})
	});

	$(document).on('blur', '.chat_message', function(){
		var is_type = 'no';
		$.ajax({
			url:"updateTypeStatus.php",
			method:"POST",
			data:{is_type:is_type},
			success:function(){
			}
		})
	});

	$(document).on('click', '.box',function() {
    $("#white").click(function() {
      $("body").removeClass();
      $("body").addClass("white");
    });
		$("#yellow").click(function() {
      $("body").removeClass();
      $("body").addClass("yellow");
    });
		$("#gray").click(function() {
      $("body").removeClass();
      $("body").addClass("gray");
    });
		$("#red").click(function() {
      $("body").removeClass();
      $("body").addClass("red");
    });
		$("#purple").click(function() {
      $("body").removeClass();
      $("body").addClass("purple");
    });
  });

	function make_chat_dialog_box(to_user_id, to_user_name){
		var modal_content = '<div id="user_dialog_' + to_user_id + '" class="user_dialog" title="You have chat with ' + to_user_name + '">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history_' + to_user_id + '">';
		modal_content += get_user_chat_history(to_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea placeholder="Write your message here.." name="chat_message_' + to_user_id + '" id="chat_message_' + to_user_id +'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

	function get_user_chat_history(to_user_id){
		$.ajax({
			url:"userChatHistory.php",
			method:"POST",
			data:{to_user_id:to_user_id},
			success:function(data){
				$('#chat_history_' + to_user_id).html(data);
			}
		})
	}

	function updateChatHistoryData(){
		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');
			get_user_chat_history(to_user_id);
		});
	}

	function fetchGroupChatHistory(){
		var groupChatActive = $('#groupChatWindow').val();
		var action = "fetch_data";
		if(groupChatActive == 'yes') {
			$.ajax({
				url:"groupChat.php",
				method:"POST",
				data:{action:action},
				success:function(data) {
					$('#group_chat_history').html(data);
				}
			})
		}
	}

	function fetch_user(){
		$.ajax({
			url:"getUser.php",
			method:"POST",
			success:function(data){
				$('#user_details').html(data);
			}
		})
	}

	function updateLastActivity(){
		$.ajax({
			url:"updateLastActivity.php",
			methods:'POST',
			success:function(){
			}
		})
	}

	$('#groupChatDialog').dialog({
		autoOpen:false,
		width:400
	});

	$('#group_chat').click(function(){
		$('#groupChatDialog').dialog('open');
		$('#groupChatWindow').val('yes');
		fetchGroupChatHistory();
	});

	$('#send_group_chat').click(function(){
		var chat_message = $.trim($('#group_chat_message').html());
		var action = 'insert_data';
		if(chat_message != '') {
			$.ajax({
				url:"groupChat.php",
				method:"POST",
				data:{chat_message:chat_message, action:action},
				success:function(data) {
					$('#group_chat_message').html('');
					$('#group_chat_history').html(data);
				}
			})
		}
		else {
			alert('Type something');
		}
	});

	$('#uploadFile').on('change', function() {
		$('#uploadImage').ajaxSubmit({
			target: "#group_chat_message",
			resetForm: true
		});
	});
});
</script>
