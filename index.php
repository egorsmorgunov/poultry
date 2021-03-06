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
		<style type="text/css">@import "assets/css/default.css";</style>
		<title><?php echo $siteTitle; ?></title>
			<script src="js/jquery-2.1.4.js"></script>
			<script type="text/javascript" src="jquery.tablesorter.js"></script>
		<script src="js/modernizr.js"></script> <!-- Modernizr -->
		<script type="text/javascript">
	
	$(function() {
		$("table").tablesorter();
	});
		</script>	
	</head>
	<body>
		<div id="wrapper">
		<a href="./" id="logo"><div>
		<audio id="myaudio" preload="auto">
           <source src="чикен.mp3">
         </audio>
		</div></a>
			<div class="cd-intro-content mask-2">
		<div class="content-wrapper">
			<div>
		
				<?php echo $headerCaption; ?>
			</div>
		</div>
	</div>
			</header>
			<div id="main">
			<nav>
			<ul class="fancyNav">
		
				<?php
				showMenu($userLevel, $module);
				displayError($errors);
				include_once $module."view.php"; 
				?>
			</ul>
			</nav>
			</div>
			</div>
			<div id="container">Информационная система управления птицефабрикой, гр. 1532K@2016 V.2.0</div>
		</div>
				<!--<script src="js/main.js"></script> --> <!-- Resource jQuery -->
			<!--<script src="http://code.jquery.com/jquery-1.6.3.min.js"></script>-->
		<script src="assets/js/jquery.shuffleLetters.js"></script>
        <script src="assets/js/script.js"></script>
		<script>
var myaudio = $("#myaudio")[0];
$("#logo")
   .mouseenter(function() {
      myaudio.play();
   });

</script>
		 
	</body>
</html>
