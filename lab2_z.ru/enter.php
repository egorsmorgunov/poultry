<?php
$login=trim($_POST["login"]);
$password=trim($_POST["password"]);
/* Проверка заполнения всех полей формы авторизации */
if(empty($login) or empty($password))
{
 ?>
   <html>
         <head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><title>Error</title></head>
		  <body>
		     <div align='center' style='background:white; width:900px; height:30 px;'>
		        <p align='center'>Одно из полей не заполнено</p>
				<a href="http://localhost/lab2_z.ru/index.html" align='center'>Назад к заполнению</a>
			 </div>
		  </body>
   </html>
<?php
exit;
}

/* Подключение к базе в случае успеха предыдущих проверок */
$mysql_login='root';
$mysql_host='localhost';
$mysql_pass='';
$mysql_db='polutry_farm';
$connect=mysql_connect($mysql_host,$mysql_login,$mysql_pass) or die("Не могу подключиться к БД MySQL: " . mysql_error());
$select=mysql_select_db($mysql_db) or die("БД с таким именем не найдена: " . mysql_error());

/* Проверяем наличие пользователя с таким логином в БД */
$query_login = mysql_query("SELECT * FROM `users` WHERE `login` = '$login' LIMIT 0 , 30") or die(mysql_error());
$answer=mysql_num_rows($query_login);
if ($answer==0)
{
  ?><html>
         <head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><title>Error</title></head>
		  <body>
		     <div  align='center' style='background:white; width:900px; height:30 px;'>
		        <p align='center'>Пользователь с таким логином в БД не найден. Предлагаем пройти регистрацию.</p>
				<a href="http://localhost/lab2_z.ru/index.html" align='center'>Перейти к регистрации</a>
			 </div>
		  </body>
   </html>
  <?php
  mysql_close($connect);
  exit;
}
/* Проверяем корректность пары логин-пароль */
$answer_pass=mysql_fetch_array($query_login);
if($answer_pass['password']!=$password)
  {
   ?><html>
         <head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><title>Error</title></head>
		  <body>
		     <div  align='center' style='background:white; width:900px; height:30 px;'>
		        <p align='center'>Пароль введен не верно.</p>
				<a href="http://localhost/lab2_z.ru/index.html" align='center'>Вернуться на главную страницу</a>
			 </div>
		  </body>
   </html>
  <?php
    mysql_close($connect);
    exit; 
  }
?><html>
         <head><meta http-equiv="Content-Type" content="text/html; charset=utf8"><title>Личный кабинет пользователя</title></head>
		  <body>
		     <div  align='center' style='background:white; width:900px; height:30 px;'>
		        <p align='center'>Личный кабинет пользователя <font color="red"><?php echo $answer_pass['login'];?></font></p>
				<p align='left'>Таблица учетных записей пользователей </p>
		        <table border="1">
				<tr><td>id</td><td>Логин</td><td>Пароль</td><td>email</td><td>ФИО</td><td>Уровень доступа</td></tr>
				<?php
				  $users=mysql_query("SELECT * FROM `users`") or die(mysql_error());
				  while($all_users=mysql_fetch_array($users))
                  {
					  echo "<tr><td>".$all_users['id']."</td><td>".$all_users['login']."</td><td>".$all_users['password']."</td><td>".$all_users['email']."</td><td>".$all_users['fio']."</td><td>".$all_users['level']."</td><tr>";
                  }
				  mysql_close($connect);
				?>						
				</table>
                <br>	
				<button name="egg_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="egg.php">Показать таблицу "Яица"</a></button>
				<button name="feed_but" style="background: #fdeaa8; width: 430px; height: 40px; border-radius: 5px; box-shadow: 0px 1px 3px; font-size: 20px;"><a href="feed.php">Показать таблицу "Корм"</a></button>
			 
			 </div>
			 
		  </body>
</html>
