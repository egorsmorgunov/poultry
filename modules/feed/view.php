<?php

if(checkPermission($errors ,$userLevel, 1, true)) {
	if($userLevel != 2) {
		if(isset($_GET['act']) && $_GET['act'] == 'add') { 
		?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=feed"; ?>">
				<table>
					<tr>
						<td>Название</td>
						<td><input type='text' name='name'></td>
					</tr>
					<tr>
						<td>Количество</td>
						<td><input type="text" name="count"></td>
					</tr>
					<tr>
						<td colspan="2"><input id="submit" class="a_demo_three" type="submit" value="Добавить"></td>
					</tr>
				</table>
			</form>
			<hr>
		<?php 
		}

		
	if(isset($_POST['name'])) {
			
	 if(empty($_POST['name']))
	 {
	 	
	 	echo   "<div class='error'>Поле название корма было не заполнено</div>";
	 }
	 else if(empty($_POST['count']))
	 {
	 	
	 	echo   "<div class='error'>Поле  количество было не заполнено</div>";
	 }
	 else
	 {
			$foodPdoStmt = $pdo->prepare("select * from food where name=?");
			$foodPdoStmt->execute(array($_POST['name']));
			$foodRow = $foodPdoStmt->fetch(PDO::FETCH_LAZY);
					
			if($foodPdoStmt->rowCount() > 0) {
				echo "<div class='question_message'>Вы закупаете корм, существующий в базе. Количество на скалде: {$foodRow['count']}".
					 " <a href='{$_SERVER['PHP_SELF']}?mod=feed&act=accept&name={$_POST['name']}&count={$_POST['count']}'".
					 " class='button no_margin'>Продолжить</a></div>";
			}
			else {
				$foodPdoStmt = $pdo->prepare("insert into food(name,count) values(?,?)");
				if($foodPdoStmt->execute(array($_POST['name'], $_POST['count']))) {
				?>
				<div class="okmessage">Корм успешно закуплен!</div>
			<?php 
				
			}
		}
		}
		}
		
		if(isset($_GET['act']) && $_GET['act'] == 'accept') {
			$foodPdoStmt = $pdo->prepare("update food set count=ifnull(count, 0)+? where name=?");
			
			if($foodPdoStmt->execute(array($_GET['count'], $_GET['name']))) {
			 ?>
				<div class="okmessage">Корм успешно закуплен!</div>
			<?php 
			}
		} 
		
		if(isset($_POST['feed'])) {
			$flag=1;
			foreach($_POST['id'] as $key => $val) {
				$foodPdoStmt = $pdo->prepare("select * from food where id=?");
				$foodPdoStmt->execute(array($val));
				$foodRow = $foodPdoStmt->fetch(PDO::FETCH_LAZY);
				if(($foodRow['count'] < $_POST['count'][$key]) || ($_POST['count'][$key] <= 0)) {
					displayError("Некорректно введено количество корма для  позиции \"{$foodRow['name']}.\"");
				}
				else {
					$foodPdoStmt = $pdo->prepare("update food set count=ifnull(count, 0)-? where id=?");
					
					if($foodPdoStmt->execute(array($_POST['count'][$key], $val))) {
						echo "<div class=\"okmessage\">Позиция \"{$foodRow['name']}\" успешно списана.</div>";
					}
				}
			}
		}
	}
	
		if(isset($_GET['act']) && $_GET['act'] == 'feed') {
			$dietPdoStmt = $pdo->prepare("select * from diet where day=dayofweek(CURDATE())");
			$dietPdoStmt->execute();
			if($dietPdoStmt->rowCount() > 0) { ?>
				<div class="recomendations">
					<table id="large" cellspacing="0"="data">
				<thead>
						<caption>Рекомендации диетолога на сегодняший день</caption>
						<tr>
							<th>Название корма</th>
							<th>Количество</th>
						</tr>
					<?php while ($dietRow = $dietPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
						<tr>
							<td><?php echo $dietRow['name'] ?></td>
							<td><?php echo $dietRow['count'] ?></td>
						</tr>
						</thead>
					<?php } ?>
					</table>
				</div>
				<?php
			}
			
			if($userLevel != 2) {
				$foodPdoStmt = $pdo->prepare("select * from food");
				$foodPdoStmt->execute();
				if($foodPdoStmt->rowCount() > 0) { ?>
					<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=feed"; ?>">
						<table id="large" cellspacing="0"="data">
				<thead>
							<tr>
								<th>Использовать</th>
								<th>Название корма</th>
								<th>Количество</th>
							</tr>
							</thead>
						<?php for ($i=0;$foodRow = $foodPdoStmt->fetch(PDO::FETCH_LAZY);$i++) { ?>
							<tr>
								<td><input type="checkbox" name="id[<?php echo $i; ?>]" value="<?php echo $foodRow['id'] ?>"></td>
								<td><?php echo $foodRow['name'] ?></td>
								<td><input type="text" name="count[<?php echo $i; ?>]" size="7" value="<?php echo $foodRow['count'] ?>"></td>
							</tr>
						<?php } ?>
						</table>
						<input id="submit" class="a_demo_three" name="feed" type="submit" value="Покормить">
					</form>
					<hr>
					<?php
				}
			}
		} 
		else {
			$foodPdoStmt = $pdo->prepare("select * from food");
			$foodPdoStmt->execute();
			if($foodPdoStmt->rowCount() > 0) { ?>
				<table id="large" cellspacing="0"="data">
				<thead>
					<tr>
						<th>Название корма</th>
						<th>Количество</th>
					</tr>
					</thead>
				<?php while ($foodRow = $foodPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
					<tr>
						<td><?php echo $foodRow['name'] ?></td>
						<td><?php echo $foodRow['count'] ?></td>
					</tr>
				<?php } ?>
				</table>
				<?php
			}
		}
	if($userLevel != 2) {
	?>
	<div class="center">
		<a href="<?php echo $_SERVER['PHP_SELF']."?mod=feed&act=add"; ?>" class="a_demo_three">Закупить корм</a>
		<a href="<?php echo $_SERVER['PHP_SELF']."?mod=feed&act=feed"; ?>" class="a_demo_three">Покормить куриц</a>
	</div>
	<?php
	}
}
?>
