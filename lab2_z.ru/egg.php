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
		        <p align='center'>Таблица "Яица" <font color="red"><?php echo $answer_pass['login'];?></font></p>
		        <table border="1">
				<tr><td>id</td><td>Дата</td><td>Количество</td><td>Единица измерения</td></tr>
				<?php
				  $eggs=mysql_query("SELECT * FROM `egg`") or die(mysql_error());
				  while($all_egg=mysql_fetch_array($eggs))
                  {
					  echo "<tr><td>".$all_egg['id']."</td><td>".$all_egg['date']."</td><td>".$all_egg['kol']."</td><td>".$all_egg['ed_izm']."</td><tr>";
                  }
				  mysql_close($connect);
				?>						
				</table>
                <br>	
				
				<button name="feed_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="egg_add.php">Добавить партию яиц</a></button>
				<button name="feed_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="egg_delete.php">Списать испортившиеся яица</a></button>
			 </div>
			 
		  </body>
</html>
