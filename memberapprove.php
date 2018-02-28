<? 
include('connectdb.php'); 
$con1 = dbconect();
// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con1,"SELECT * FROM regist");

session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

$sessvar=$_SESSION['lang'];


?>


<?php
$time= date('m/d/Y h:i:s a', time());
$dvar=$_GET['dvar'];
$checkedIdString1=$_GET['checkedIdString1'];

$idArray = array();
$length=$_GET['length'];
$lengthclass=$_GET['lengthclass'];

for($i=0; $i<$length; $i++){
	$idstr='idstring'.$i;	
	$idArray[] = $_GET[$idstr];
}
for($i=0; $i<$length; $i++){
	$classstr='class'.$i;	
	$classArray[] = $_GET[$classstr];
}

for($i=0; $i<$length; $i++){
 mysqli_query($con1,"UPDATE regist SET approved='1', approveddate='$time' where id='{$idArray[$i]}'");
}

$aa1="sa";//$_POST['idname1']; 

$main = array('idArray'=>$idArray, 'classArray'=>$classArray , 'value'=>array("length"=>"$length" ,"lengthclass"=>"$lengthclass" ));
echo json_encode($main); 


mysqli_close($con1);
?>