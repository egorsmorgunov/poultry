<?php
if(checkPermission($errors ,$userLevel, 99, false)) {
	
	if(isset($_POST['user'])) { 
		
		$usersPdoStmt = $pdo->prepare("select * from users where id=?");
		$usersPdoStmt->execute([$_POST['user']]);
		if($usersPdoStmt->rowCount() > 0) {
		$UserRow = $usersPdoStmt->fetch(PDO::FETCH_LAZY);
			
	?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=users&id={$UserRow['id']}"; ?>">
				<table>
					<tr>
						<td>ФИО</td>
						<td><input type="text" name="fullname" size="30" maxlength="50" value = "<?php echo $UserRow['full_name']; ?>"></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="email" size="30" value="<?php echo $UserRow['email']; ?>"></td>
					</tr>
					<tr>
						<td>Права доступа</td>
						<td><input name="level" type="text"  size="30" value="<?php echo $UserRow['level']; ?>"></td>
					</tr>
					<tr>
						<td colspan="2"><input id="submit" class="button" type="submit" value="Обновить"></td>
					</tr>
				</table>
			</form>
			<hr>
	<?php 
		}
	}
	
	if(isset($_POST['fullname'])) { 
		$usersPdoStmt = $pdo->prepare("update users set full_name=?, email=?, level=? where id=?");
		if($usersPdoStmt->execute([$_POST['fullname'], $_POST['email'], $_POST['level'], $_GET['id']])) {
	?>
		<div class="okmessage">Запись успешно обновлена!</div>
	<?php 
		}
	}
	
	$usersPdoStmt = $pdo->prepare("select * from users");
	$usersPdoStmt->execute();
	if($usersPdoStmt->rowCount() > 0) { ?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=users"; ?>">
			<table class="data fullwidth">
				<tr class="header">
					<td>Выбрать</td>
					<td>Идентификатор</td>
					<td>Логин</td>
					<td>Эл. почта</td>
					<td>ФИО</td>
					<td>Уровень доступа</td>
				</tr>
			<?php while ($UserRow = $usersPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
				<tr>
					<td><input type="radio" name="user" value='<?php echo $UserRow['id'] ?>'></td>
					<td><?php echo $UserRow['id'] ?></td>
					<td><?php echo $UserRow['login'] ?></td>
					<td><?php echo $UserRow['email'] ?></td>
					<td><?php echo $UserRow['full_name'] ?></td>
					<td>
						<?php if($UserRow['level'] == 99) echo "Администратор"; ?>
						<?php if($UserRow['level'] > 2 && $UserRow['level'] < 99) echo "Помощник администратора"; ?>
						<?php if($UserRow['level'] == 2) echo "Диетолог"; ?>
						<?php if($UserRow['level'] == 1) echo "Наблюдатель"; ?>
						<?php if($UserRow['level'] == 0) echo "Не активирован"; ?>
					</td>
				</tr>
			<?php } ?>
			</table>
			<input class="button" type="submit" value="Редактировать">
		</form>
		<?php
	}
}
?>
