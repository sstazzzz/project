<!DOCTYPE html>
<html lang="ru">
<head>
	<?php
	$title = "Поиск";
	define("ROOT_PATH",  __DIR__."/../../");
	require_once(ROOT_PATH.'block/head.php');
	?>
</head>
<?php 
require_once(ROOT_PATH.'block/menu.php');
require_once(ROOT_PATH.'block/leftsidebar.php');
$linktext = "Поиск";
require_once(ROOT_PATH.'block/content.php');
require_once(ROOT_PATH.'block/footer.php');
?>
<!-- <script type="text/javascript" src="jssearch.js"></script> -->