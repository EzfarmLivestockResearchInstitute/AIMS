<?php
session_start();
	$lang = $_GET['lang'];
	$_SESSION['lang'] = $lang;
	echo('하하하 lang 이 "'. $lang.'" 으로 바뀌었네요: <br>');
?>

