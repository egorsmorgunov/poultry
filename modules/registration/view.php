<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=registration"; ?>" accept-charset="UTF-8">
	<table class="form">
		<tr>
			<td>Логин</td>
			<td><input type="text" name="login"></td>
		</tr>
		<tr>
			<td>Пароль</td>
			<td><input type="password" name="password1"></td>
		</tr>
		<tr>
			<td>Повторение пароля</td>
			<td><input type="password" name="password2"></td>
		</tr>
		<tr>
			<td>Электронная почта</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>ФИО</td>
			<td><input type="text" name="fullname"></td>
		</tr>
		<tr>
			<td><a href="./?mod=login">Авторизация</a></td>
			<td class="submit"><button type="submit" class="button">Зарегистрироваться</button></td>
		</tr>
	</table>
</form>
