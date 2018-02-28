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

$pidco=$_GET['pidco'];
$pidrc=$_GET['pidrc'];
$pid=$_GET['pid'];
$flag=$_GET['flag'];
$count=$_GET['count'];

//삭제
if($flag=='d'){
$q_flag="UPDATE board SET DeleteOrNot='0' where  PID='{$pidrc}'";
}
$sth = $dbo->prepare($q_flag);
$sth->execute();

$main = array('value'=>array("pidco"=>"$pidco", "flag"=>"$flag","pid"=>"$pid","count"=>"$count","pidrc"=>"$pidrc" ));
echo json_encode($main); 
?>