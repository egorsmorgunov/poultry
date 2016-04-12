<?php
include_once "./system/config.php";
include_once "./system/sys_lib.php";
include_once "./system/mod_lib.php";
	
$pdo = connectDb($dbHost, $dbName, $dbUser, $dbPassword, $dbCharset);
initSession($errors, $pdo);
$userLevel = getUserLevel($pdo);

$defaultModule = setDefaultModule($userLevel);
$module = setModule($defaultModule);

include_once $module."logic.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="./client_side/style.css" >
		<title><?php echo $siteTitle; ?></title>
	</head>
	<body>
		<div id="wrapper">
			<header id="site_header">
				<a href="./" id="logo"><div></div></a>
				<h1><?php echo $headerCaption; ?></h1>
			</header>
			<div id="main">
				<?php
				showMenu($userLevel, $module);
				displayError($errors);
				include_once $module."view.php"; 
				?>
			</div>
			<footer id="site_footer">
				Информационная система управления птицефабрикой, гр. 5231@2016
			</footer>
		</div>
	</body>
</html>
