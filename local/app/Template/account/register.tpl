<head>
	<script type="text/javascript" src='/public/scripts/account/autorise.js'></script>
</head>
<div class='background_blure'></div>
<div class='clyde_message_login'>
	<ul class='clyde_message'>
			<a>Выбор: Активирован*(?*:%)<br><br>
			<b>Введите ваши данные</b></a>
	<ul>
</div>

<form action="/account/register" method=post class="register_form">
	<a href="/"></a>
	<input type=text size="30" name=login placeholder="Имя" value=""><br><br>
	<input type=email size="30" name=email placeholder="Email" value=""><br><br>
	<input type=password size="30" name=pass placeholder="Пароль"><br><br>
	<input type=password size="30" name=pass2 placeholder="Подтвердите пароль"><br><br>
	<input type=submit size="30" name=reg value="Зарегистрироваться">
</form>
