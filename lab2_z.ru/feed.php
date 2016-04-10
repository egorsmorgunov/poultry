<?php
header('Content-Type: text/html; charset=utf-8');
$login=trim($_POST["login"]);
$password=trim($_POST["password"]);

/* Подключение к базе в случае успеха предыдущих проверок */
$mysql_login='root';
$mysql_host='localhost';
$mysql_pass='';
$mysql_db='polutry_farm';
$connect=mysql_connect($mysql_host,$mysql_login,$mysql_pass) or die("Не могу подключиться к БД MySQL: " . mysql_error());
$select=mysql_select_db($mysql_db) or die("БД с таким именем не найдена: " . mysql_error());
?>
<html>
         <head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><title>Личный кабинет пользователя</title></head>
		  <body>
		     <div  align='center' style='background:white; width:900px; height:30 px;'>
		        <p align='center'>Таблица "Корм" <font color="red"><?php echo $answer_pass['login'];?></font></p>
		        <table border="1">
				<tr><td>id</td><td>Наименование корма</td><td>Количество</td><td>Единица измерения</td></tr>
				<?php
				  $feeds=mysql_query("SELECT * FROM `feed`") or die(mysql_error());
				  while($all_feed=mysql_fetch_array($feeds))
                  {
					  echo "<tr><td>".$all_feed['id']."</td><td>".$all_feed['name_feed']."</td><td>".$all_feed['kol']."</td><td>".$all_feed['ed_izm']."</td><tr>";
                  }
				  mysql_close($connect);
				?>						
				</table>
                <br>	
				<button name="egg_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="feed_add.php">Закупить корм</a></button>
				<button name="feed_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="feed_delete.php">Покормить куриц</a></button>
			 
			 </div>
			 
		  </body>
</html>
