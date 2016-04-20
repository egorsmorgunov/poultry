<?php
//here all functions, which use for work of system and modules lib

//used PDO, because mysql functions is deprecated
function connectDb($host, $db, $user, $pass, $charset) {
	$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
	$opt = array(
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	$pdo = new PDO($dsn, $user, $pass, $opt);
	
	return $pdo;
}

function initSession(&$e,$pdo) {
 session_start();
 if(!isset($_SESSION['id']) && isset($_COOKIE['id'])) {
  $stmt = $pdo->prepare("select id from users where unique_id = ?");
  $cookie[0] = $_COOKIE['id'];
  $stmt->execute($cookie);
  $row_count = $stmt->rowCount();
  
  if($row_count == 1) {
   $resultId = $stmt->fetchColumn();
   $_SESSION['id'] = $resultId;
  }
  else {
   $e[] = "Ваши cookies не актуальны. Авторизуйтесь для доступа к сайту.";
   setcookie("id","",time()-1, "/");
  }
 }
}

function getUserLevel($pdo)
{
 if(isset($_SESSION['id']))
  {
  $data[1] = $_SESSION['id'];
 }
 elseif(isset($_COOKIE['id']))
 {
  $data[1] = $_COOKIE['unique_id'];
 }
 else $data = false;
 
 
 if($data)
 {
  $stmt = $pdo->prepare('select level from users where id = :id');
  
  //$dataa[1] = $data[1];
  $stmt->execute(array(':id' => $data[1]));
  
  $row_count = $stmt->rowCount();
  
  
  if($row_count == 1) {
   $resultLevel = $stmt->fetchColumn();
   
   return $resultLevel;
  }
 }
 return 0;
}

function setModule($defaultModule) {
	if(isset($_GET['mod']) && file_exists("./modules/{$_GET['mod']}")) {
		$mod = "./modules/{$_GET['mod']}/";
	} 
	else {
		$mod = "./modules/{$defaultModule}/";
	}
	
	return $mod;
}

function setDefaultModule($userLevel) {
	if($userLevel >= 99) return "users";
	elseif($userLevel >= 2) return "diet";
	elseif($userLevel >= 1) return "eggs";
	else return "login";
}

function displayError($errors) {
	if(is_array($errors)) {
		foreach ($errors as $err) {
			echo "<div class=\"error\">{$err}</div>";
		}
	}
}

	
function showMenu($userLevel, $module) {
$menu[99][] = array ("users" , "Пользователи");
$menu[2][] = array ("diet" , "Диета");
$menu[1][] = array("eggs" ,"Яйца");
$menu[1][] = array("feed" , "Корм");

if (($userLevel > 0) && (isset($_SESSION['id']) && isset($_COOKIE['id'])))
{foreach($menu as $key => $val)
{
foreach($val as $key2 => $val2)
{
if($userLevel >= $key)
{
if("./modules/".$val2[0]."/" == $module)
{
echo "<li id=\"about\"><a href=\"./?mod={$val2[0]}\".>{$val2[1]}</a></li>";
}
else{
echo "<li id=\"about\"><a href=\"./?mod={$val2[0]}\".>{$val2[1]}</a></li>";
}
}
}
}
echo "<li id=\"contact\"><a href=\"index.php?mod=login&amp;exit=1\">Выход</a></li>";

}
}

function checkPermission(&$e ,$userLevel, $validLevel, $showError) {
	if($userLevel >= $validLevel) {
		return true;
	}
	elseif($showError) $e[] = "У вас недостаточно прав для доступа к этому разделу.";
	return false;
}
?>
