<?php 
if($userLevel > 0) header('Location: ./');

$siteTitle = "Регистрация пользователя";
$headerCaption = "Регистрация пользователя";

if(isset($_POST['login']) && isset($_POST['password1']) &&
   isset($_POST['password2']) && isset($_POST['email']) &&
   isset($_POST['fullname'])) {
	if(isValidLogin($errors, $_POST['login']) && 
	   isLoginExists($errors, $pdo, $_POST['login'],false) &&
	   isValidPassword($errors, $_POST['password1']) &&
	   isPasswordsMatch($errors, $_POST['password1'], $_POST['password2']) &&
	   isValidEmail($errors, $_POST['email']) &&
	   isValidFullName($errors, $_POST['fullname'])) {
		
		registration($errors, $pdo, $_POST['login'], $_POST['password1'],
					 $_POST['email'],$_POST['fullname']);
		header('Location: ./');
	}
}






?>
