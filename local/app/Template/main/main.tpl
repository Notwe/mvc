<head>
	<script type="text/javascript" src="/public/scripts/main/chat.js"></script>
</head>
<div class='main_left_menu'>
	<div class="hello_user" >Привет&nbsp;&nbsp;&nbsp;<a href='#'><b><?=$user_name ?? 'Гость';?></a></b></div>
	<div class='public_room_list'> Тут общие комнаты
	</div>
	<div class='private_room_list'> тут Приват комнаты доступные юзеру
	</div>
	<div class='friend_list'> список друзей
	</div>
</div>

<div class='main_box' id='main_box'>
	<ul id='error_message'></ul>
	<div class='message_box' id='message_box'></div>
	<div class='send_message'>
		<textarea class='user_send_message' name='send_message'></textarea>
		<input class='button_send_message' type=button>
	</div>
</div>
