<?php 
if($userLevel > 0) header('Location: ./');

$siteTitle = "Авторизация пользователя";
$headerCaption = "Авторизация пользователя";

if(isset($_POST['login']) && isset($_POST['password'])) {
	if(isValidLogin($errors, $_POST['login']) && 
	   isLoginExists($errors, $pdo, $_POST['login'], true) &&
	   isValidPassword($errors, $_POST['password'])) {
		
		authorization($errors, $pdo, $_POST['login'], $_POST['password']);
		header('Location: ./');
	}
}

if(isset($_GET['exit']) && ($_GET['exit']) == 1) {
	setcookie("id","",time()-1, "/");
	session_destroy();
}




?>
