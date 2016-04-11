<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=login"; ?>" accept-charset="UTF-8">
	<table class="form">
		<tr>
			<td>Логин</td>
			<td><input type="text" name="login"></td>
		</tr>
		<tr>
			<td>Пароль</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td><a href="./?mod=registration">Регистрация</a></td>
			<td class="submit"><button type="submit" class="button">Войти</button></td>
		</tr>
	</table>
</form>
