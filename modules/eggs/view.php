<?php

if(checkPermission($errors ,$userLevel, 1, true)) {
	if($userLevel != 2) {
		if(isset($_GET['act']) && $_GET['act'] == 'add') { 
		?>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?mod=eggs"; ?>">
				<table>
					<tr>
						<td>Дата</td>
						<td><input name='date' type='date'></td>
					</tr>
					<tr>
						<td>Количество</td>
						<td><input type="text" name="count" size="20"></td>
					</tr>
					<tr>
						<td colspan="2"><input id="submit" class="a_demo_three" type="submit" value="Добавить"></td>
					</tr>
				</table>
			</form>
			<hr>
		<?php 
		}


		if(isset($_POST['date'])) {
			
			$eggsPdoStmt = $pdo->prepare("select * from eggs where date=?");
			$eggsPdoStmt->execute(array($_POST['date']));
					
			if($_POST['date'] < date('Y-m-d', strtotime('-7 days'))) displayError("Партия не может быть внесена за дату, позже сегодняшней более чем на 7 дней.");
			elseif($_POST['date'] > date('Y-m-d')) displayError("Партия не может быть внесена за будущие даты.");
			elseif($eggsPdoStmt->rowCount() > 0) {
				echo "<div class='question_message'>Вы вносите яйца за дату, существующую в базе.".
					 " <a href='{$_SERVER['PHP_SELF']}?mod=eggs&act=accept&date={$_POST['date']}&count={$_POST['count']}'".
					 " class='button no_margin'>Продолжить</a></div>";
			}
			else {
				$eggsPdoStmt = $pdo->prepare("insert into eggs(date,count) values(?,?)");
				if($eggsPdoStmt->execute(array($_POST['date'], $_POST['count']))) {
				?>
				<div class="okmessage">Партия успешно добавлена!</div>
			<?php 
				}
			}
		}
		
		if(isset($_GET['act']) && $_GET['act'] == 'accept') {
			$eggsPdoStmt = $pdo->prepare("update eggs set count=ifnull(count, 0)+? where date=?");
			
			if($eggsPdoStmt->execute($_GET['count'], $_GET['date'])) {
			 ?>
				<div class="okmessage">Партия успешно добавлена!</div>
			<?php 
			}
		} 
		
		if(isset($_GET['act']) && $_GET['act'] == 'remove') {
			$eggsPdoStmt = $pdo->prepare("delete from eggs where date < DATE_SUB(CURRENT_DATE, INTERVAL 2 MONTH)");
			
			if($eggsPdoStmt->execute()) {
			 ?>
				<div class="okmessage">Испортившиеся яйца успешно списаны!</div>
			<?php 
			}
		}
	} 
	
	$eggsPdoStmt = $pdo->prepare("select * from eggs");
	$eggsPdoStmt->execute();
	if($eggsPdoStmt->rowCount() > 0) { ?>
		<table id="large" cellspacing="0"="data">
				<thead>
			<tr>
				<th>Дата</th>
				<th>Количество</th>
			</tr>
			</thead>
		<?php while ($eggRow = $eggsPdoStmt->fetch(PDO::FETCH_LAZY)) { ?>
			<tr>
				<td><?php echo $eggRow['date'] ?></td>
				<td><?php echo $eggRow['count'] ?></td>
			</tr>
		<?php } ?>
		</table>
		<?php
	}
	if($userLevel != 2) {
	?>
		<div class="center">
			<a href="<?php echo $_SERVER['PHP_SELF']."?mod=eggs&act=add"; ?>" class="a_demo_three">Добавить партию яиц</a>
			<a href="<?php echo $_SERVER['PHP_SELF']."?mod=eggs&act=remove"; ?>" class="a_demo_three">Списать испортившиеся яйца</a>
		</div>
	<?php
	}
}
?>
