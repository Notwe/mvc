<div class='background_blure'></div>
<div class='clyde_message_login'>
	<ul class='clyde_message'>
		<?=$user_data['name'] ?? 'Гость'?>
			<a>Выбор: Активирован*(?*:%)<br><br>
			<b>Авторизируйтесь</b></a>

	<ul>
</div>
<div class='autorise_box'>
	<a href="/"></a>
	<form action="/account/login" method="POST" class='user_login'>
		<input type=text name=login placeholder='Имя'><br>
		<input type=password name=password placeholder='Пароль'>
		<input type=submit id='user_login' name=enter value='Войти'>
		<ul id='error_message'>

		</ul>
	</form>
