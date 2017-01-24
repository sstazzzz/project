<!DOCTYPE html>
<html lang="en">
<head>
	<?php
	$title = "Сборники";
	define("ROOT_PATH",  __DIR__."/../../");
	require_once(ROOT_PATH.'block/head.php');
	?>
</head>
<?php 
require_once(ROOT_PATH.'block/menu.php');
require_once(ROOT_PATH.'block/leftsidebar.php');
$linktext = "Категории &#8594 Сборники";
require_once(ROOT_PATH.'block/content.php');
require_once(ROOT_PATH.'block/footer.php');
?>