<?php
if(checkPermission($errors ,$userLevel, 99, false)) {
	$usersPdoStmt = $pdo->prepare("select * from users");
	$usersPdoStmt->execute();
	if($usersPdoStmt->rowCount() > 0) { ?>
		
		<table class="data">
			<tr class="header">
				<td>Идентификатор</td>
				<td>Логин</td>
				<td>Эл. почта</td>
				<td>ФИО</td>
				<td>Уровень доступа</td>
			</tr>
		<?php while ($UserRow = $usersPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
			<tr>
				<td><?php echo $UserRow['id'] ?></td>
				<td><?php echo $UserRow['login'] ?></td>
				<td><?php echo $UserRow['email'] ?></td>
				<td><?php echo $UserRow['full_name'] ?></td>
				<td><?php echo $UserRow['level'] ?></td>
			</tr>
		<?php } ?>
		</table>
		
		<?php
	}
}
?>
