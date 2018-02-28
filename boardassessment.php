<?Php
require "config.php";	// connection details

error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}
$sessvar=$_SESSION['lang'];
?>

<?php
$pid=$_GET['pid'];
$flag=$_GET['flag'];
$count=$_GET['count'];

$main = array('value'=>array("pid"=>"$pid", "flag"=>"$flag","count"=>"$count" ));
echo json_encode($main); 
?>