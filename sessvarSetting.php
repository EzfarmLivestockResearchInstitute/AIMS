<?
session_start();
	if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}
?>