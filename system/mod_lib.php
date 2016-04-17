<?php

//here all functions, which use for work of modules

function getBack() {
	return "<a href=\"".$_SERVER['HTTP_REFFERER']."\">Вернуться назад</a>";
}

function isValidLogin(&$e, $login) {
	$valid = true;
	
	if(empty($login)) {
		$e[] = 'Поле "логин" не заполнено.';
		$valid = false;
	}
	elseif (!preg_match ("/[a-z0-9]{1,10}/", $login)) {
		$e[] = 'Поле "логин" не соответствует формату. (1-10 символов, '.
				'прописные лат. буквы и цифры)';
		$valid = false;
	}
	
	return $valid;
}

function isValidFullName(&$e, $fullName) {
	$valid = true;
	
	if(empty($fullName)) {
		$e[] = 'Поле "ФИО" не заполнено.';
		$valid = false;
	}
	elseif (!preg_match ("/[a-zа-яё ]{5,50}/i", $fullName)) {
		$e[] = 'Поле "ФИО" не соответствует формату. (5-50 символов, '.
				'прописные и строчные буквы латиницей.)';
		$valid = false;
	}
	
	return $valid;
}

function isValidPassword(&$e, $password) {
	$valid = true;
	
	if(empty($password)) {
		$e[] = 'Поле "пароль" не заполнено.';
		$valid = false;
	}
	elseif(!preg_match('/[0-9A-Za-z]{8,12}/', $password)) {
		$e[] = 'Поле "пароль" не соответствует формату. (8-12 символов'.
				',строчные и прописные лат. буквы, цифры и символы "! @ # $ %".)';
		$valid = false;
	}
	
	return $valid;
}

function isValidEmail(&$e, $email) {
	$valid = true;
	
	if(empty($email)) {
		$e[] = 'Поле "электронная почта" не заполнено.';
		$valid = false;
	}
	elseif(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		$e[] = 'Поле "электронная почта" не соответствует формату.'.
				'(строчные и прописные лат. буквы, цифры и символы "@ .".)';
		$valid = false;
	}
	
	return $valid;
}

function isPasswordsMatch(&$e, $password1, $password2) {
	if(strcmp($password1, $password2) != 0) {
		$e[] = 'Пароли не совпадают.';
		return false;
	}
	
	return true;
}

function isLoginExists(&$e, $pdo, $login, $intent) {
		$loginn[0] = $login;
		$stmt = $pdo->prepare("select id from users where login = ?");
		$stmt->execute($loginn);
		$rowCount = $stmt->rowCount();
		
		if($intent) {
			if($rowCount != 1) {
				$e[] = 'Пользователя с таким логином не существует.';
				return false;
			}
		}
		else {
			if($rowCount == 1) {
				$e[] = 'Пользователя с таким логином уже существует.';
				return false;
			}
		}
		
		return true;
}

function authorization(&$e, $pdo, $login, $password) {
  $stmt = $pdo->prepare("select * from users where login = ? and password = ?");
  $loginn[0] = $login;
  $loginn[1] = md5($password);
  $stmt->execute($loginn);
  $rowCount = $stmt->rowCount();
  $resultArr = $stmt->fetch(PDO::FETCH_LAZY);
  if($rowCount != 1) {
   $e[] = 'Неправильный логин/пароль.';
   return false;
  }
  else {
   setcookie("id",$resultArr['unique_id'],time() + 60*60*24*62, "/");
   $_SESSION['id'] = $resultArr['id'];
   return true;
  }
}

function registration(&$e, $pdo, $login, $password, $email, $fullname) {
  $loginn[0] = $login;
  $loginn[1] = md5($password);
  $loginn[2] = $email;
  $loginn[3] = $fullname;
  $loginn[4] = 0;
  $loginn[5] = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].mktime());

  $stmt = $pdo->prepare("insert into users(login, password, email, full_name,".
         "level, unique_id) values(?, ?, ?, ?, ?, ?)");
  $stmt->execute($loginn);

  setcookie("id",$unique_id,time() + 60*60*24*62, "/");
}

?>
