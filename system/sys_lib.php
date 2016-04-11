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
		$stmt->execute([$_COOKIE['id']]);
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

function getUserLevel($pdo) {
	if(isset($_SESSION['id'])) {
		$data = [&$_SESSION, 'id'];
	}
	elseif(isset($_COOKIE['id'])) {
		$data = [&$_COOKIE, 'unique_id'];
	}
	else $data = false;
	
	if($data) {
		$stmt = $pdo->prepare("select level from users where {$data[1]} = ?");
		$stmt->execute([$data[0]['id']]);
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
	if($errors) {
		foreach ($errors as $err) {
			echo "<div class=\"error\">{$err}</div>";
		}
	}
}

function showMenu($userLevel, $module) {
	$menu[99][] = ["users", "Пользователи"];
	$menu[2][] = ["diet", "Диета"];
	$menu[1][] = ["eggs", "Яйца"];
	$menu[1][] = ["feed", "Корм"];
	
	if($userLevel > 0) {
		echo "<div class=\"menu\">";
			foreach($menu as $key => $val) {
				foreach($val as $key2 => $val2) {
					if($userLevel >= $key)  {
						if("./modules/".$val2[0]."/" == $module) {
							echo "<span>{$val2[1]}</span>";
						}
						else {
							echo "<a href=\"./?mod={$val2[0]}\">{$val2[1]}</a>";
						}
					}
				}
			}
			 
		echo "</div>";
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
