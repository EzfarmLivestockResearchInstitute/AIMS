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
$id=$_GET['id'];
$name=$_GET['name'];

//삭제
if($id==$name & $flag=='d'){
$q_flag="UPDATE board SET num=0 , DeleteOrNot=0 where  PID='{$pid}'";
}
$sth = $dbo->prepare($q_flag);
$sth->execute();

$main = array('value'=>array("pid"=>"$pid", "flag"=>"$flag", "count"=>"$count","id"=>"$id","name"=>"$name" ));
echo json_encode($main); 
?>