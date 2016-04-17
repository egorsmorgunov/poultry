<?php

if(checkPermission($errors ,$userLevel, 2, true)) {
	
	if(isset($_GET['act']) && $_GET['act'] == 'add') { 
	?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=diet"; ?>">
			<table id="large" cellspacing="0">
				<tr>
					<td>Название</td>
					<td><input type='text' name='name'></td>
				</tr>
				<tr>
					<td>Количество</td>
					<td><input type="text" name="count"></td>
				</tr>
				<tr>
					<td>День недели</td>
					<td>
						<select name="day">
							<option value="2">Понедельник</option>
							<option value="3">Вторник</option>
							<option value="4">Среда</option>
							<option value="5">Четверг</option>
							<option value="6">Пятница</option>
							<option value="7">Суббота</option>
							<option value="1">Воскресеньте</option>
						</select>
					</td>
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
			$dietPdoStmt = $pdo->prepare("select * from diet where day=? and name=?");
			$dietPdoStmt->execute(array($_POST['day'],$_POST['name']));
					
			if($dietPdoStmt->rowCount() > 0) {
				echo "<div class='question_message'>Рекомендация с такой датой и названием уже существует в базе.".
					 " <a href='{$_SERVER['PHP_SELF']}?mod=diet&act=accept&day={$_POST['day']}&name={$_POST['name']}&count={$_POST['count']}'".
					 " class='button no_margin'>Продолжить</a></div>";
			}
			else {
				$dietPdoStmt = $pdo->prepare("insert into diet(name,count,day) values(?,?,?)");
				if($dietPdoStmt->execute(array($_POST['name'], $_POST['count'], $_POST['day']))) {
				?>
				<div class="okmessage">Рекомендация успешно добавлена!</div>
			<?php 
			}
		}
	}
	
	if(isset($_GET['act']) && $_GET['act'] == 'accept') {
		$dietPdoStmt = $pdo->prepare("update diet set count=ifnull(count, 0)+? where name=? and day=?");
		
		if($dietPdoStmt->execute($_GET['count'], $_GET['name'], $_GET['day'])) {
		 ?>
			<div class="okmessage">Рекомендация успешно добавлена!</div>
		<?php 
		}
	} 
	
	if(isset($_POST['diet'])) {
		$flag=1;
		if(isset($_POST['id'])) {
			foreach($_POST['id'] as $key => $val) {
				$flag = substr($val, -1);
				$val = substr($val, 0, -1);
				
				if($flag == "c") {
					$dietPdoStmt = $pdo->prepare("select * from diet where id=?");
					$dietPdoStmt->execute($val);
					$dietRow = $dietPdoStmt->fetch(PDO::FETCH_LAZY);
					if($_POST['count'][$key] <= 0) {
						displayError("Некорректно введено количество корма для  позиции \"{$dietRow['name']}.\"");
					}
					else {
						$dietPdoStmt = $pdo->prepare("update diet set count=?, day=? where id=?");
						
						if($dietPdoStmt->execute($_POST['count'][$key], $_POST['day'][$key], $val)) {
							echo "<div class=\"okmessage\">Позиция \"{$dietRow['name']}\" успешно изменена.</div>";
						}
					}
				}
				elseif($flag == "d") {
					$dietPdoStmt = $pdo->prepare("delete from diet where id=?");
					
					if($dietPdoStmt->execute(array($val))) {
						echo "<div class=\"okmessage\">Позиция \"{$dietRow['name']}\" успешно удалена.</div>";
					}
				}
			}
		}
	}
	
	if(isset($_GET['act']) && $_GET['act'] == 'change') {
		$dietPdoStmt = $pdo->prepare("select * from diet");
		$dietPdoStmt->execute();
		if($dietPdoStmt->rowCount() > 0) { ?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=diet"; ?>">	
				<table id="large" cellspacing="0"="data">
				<thead>
					<tr>
						<th>Изменить</th>
						<th>Удалить</th>
						<th>Название корма</th>
						<th>Количество</th>
						<th>День</th>
					</tr>
					</thead>
				<?php for ($i=0;$dietRow = $dietPdoStmt->fetch(PDO::FETCH_LAZY);$i++) { ?>
					<tr>
						<td><input type="radio" name="id[<?php echo $i; ?>]" value="<?php echo $dietRow['id']."c"; ?>"></td>
						<td><input type="radio" name="id[<?php echo $i; ?>]" value="<?php echo $dietRow['id']."d"; ?>"></td>
						<td><?php echo $dietRow['name'] ?></td>
						<td><input type="text" name="count[<?php echo $i; ?>]" size="7" value="<?php echo $dietRow['count'] ?>"></td>
						<td>
							<select name="day[<?php echo $i; ?>]">
								<option value="2" <?php if($dietRow['day'] == 2) echo "selected"; ?>>Понедельник</option>
								<option value="3" <?php if($dietRow['day'] == 3) echo "selected"; ?>>Вторник</option>
								<option value="4" <?php if($dietRow['day'] == 4) echo "selected"; ?>>Среда</option>
								<option value="5" <?php if($dietRow['day'] == 5) echo "selected"; ?>>Четверг</option>
								<option value="6" <?php if($dietRow['day'] == 6) echo "selected"; ?>>Пятница</option>
								<option value="7" <?php if($dietRow['day'] == 7) echo "selected"; ?>>Суббота</option>
								<option value="1" <?php if($dietRow['day'] == 1) echo "selected"; ?>>Воскресеньте</option>
							</select>
						</td>
					</tr>
				<?php } ?>
				</table>
				<input id="submit" class="a_demo_three" name="diet" type="submit" value="Применить">
			</form>
			<hr>
			<?php
		}

	} 
	else {
		$dietPdoStmt = $pdo->prepare("select * from diet");
		$dietPdoStmt->execute();
		if($dietPdoStmt->rowCount() > 0) { ?>
			<table id="large" cellspacing="0">
			<thead>
				<tr>
					<th>Название корма</th>
					<th>Колличество</th>
					<th>День недели</th>
				</tr>
				</thead>
			<?php while ($dietRow = $dietPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
				<tr>
					<td><?php echo $dietRow['name'] ?></td>
					<td><?php echo $dietRow['count'] ?></td>
					<td>
						<?php if($dietRow['day'] == 2) echo "Понедельник"; ?>
						<?php if($dietRow['day'] == 3) echo "Вторник"; ?>
						<?php if($dietRow['day'] == 4) echo "Среда"; ?>
						<?php if($dietRow['day'] == 5) echo "Четверг"; ?>
						<?php if($dietRow['day'] == 6) echo "Пятница"; ?>
						<?php if($dietRow['day'] == 7) echo "Суббота"; ?>
						<?php if($dietRow['day'] == 1) echo "Воскресеньте"; ?>
					</td>
				</tr>
			<?php } ?>
			</table>
			<?php
		}
	}
	?>
	<div class="center">
		<a href="<?php echo $_SERVER['PHP_SELF']."?mod=diet&act=add"; ?>" class="a_demo_three">Добавить рекомендацию</a>
		<a href="<?php echo $_SERVER['PHP_SELF']."?mod=diet&act=change"; ?>" class="a_demo_three">Изменить/удалить рекомендации</a>
	</div>
	<?php
	
}
?>