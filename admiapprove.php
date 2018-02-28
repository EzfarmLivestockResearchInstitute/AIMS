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

$idArray = array();
$valArray = array();
$length=$_GET['length'];

$idArray1 = array();
$valArray1 = array();
$length1=$_GET['length1'];

for($i=0; $i<$length; $i++){
	$idstr='id'.$i;	
	$valstr='val'.$i;
	$idArray[] = $_GET[$idstr];
	$valArray[] = $_GET[$valstr];
}

for($ii=0; $ii<$length1; $ii++){
	$idstr1='idd'.$ii;	
	$valstr1='vall'.$ii;
	$idArray1[] = $_GET[$idstr1];
	$valArray1[] = $_GET[$valstr1];
}

for($i=0; $i<$length; $i++){
 mysqli_query($con1,"UPDATE regist SET flaguser='$valArray[$i]' where id='$idArray[$i]'");
}


for($ii=0; $ii<$length1; $ii++){
 mysqli_query($con1,"UPDATE regist SET approved='$valArray1[$ii]' where  CONCAT(id ,'1')='$idArray1[$ii]'");
}

$aa1="sa";//$_POST['idname1']; 

$main = array('idArray'=>$idArray, 'valArray' => $valArray);
echo json_encode($main); 


mysqli_close($con1);
?>