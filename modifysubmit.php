<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

$sessvar=$_SESSION['lang'];

$pid=$_GET['pid'];

//echo $pid;
?>

<html lang="ko">
<head>
<meta charset="utf-8">
<title> TEST </title>
<link href="style.css" rel="stylesheet"/>
<style type="text/css">a {text-decoration: none}</style>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>


<script type="text/javascript">
var sURL = unescape(window.location.pathname);// 현재의 페이지를 언어만 변경 후 다시 열기

//언어 변경 합수 
function changeLang(lang){
	$.ajaxSetup({async:false});//동기식으로 지정
	var param={lang:lang};
	$.get("changelangsession.php", param, refreshpage);
	// param을 넘겨 서버측 php 파일 실행 후  클라이언트 측 함수 refresshpage 실행하여라. 
}; 

function refreshpage(strText){
	//alert("parsed data: " + strText);
    window.location.href = sURL;// refresh page
}
</script>
</head>

<body>
<?php

//require connectdb.php;
   include('connectdb.php'); 
   $con1 = dbconect();

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// SQL INJECTION escape
$Owners_name = mysqli_real_escape_string($con1, $_POST['Owners_name']);
$lat_deg = mysqli_real_escape_string($con1, $_POST['lat_deg']); 
$lat_min = mysqli_real_escape_string($con1, $_POST['lat_min']); 
$lat_sec = mysqli_real_escape_string($con1, $_POST['lat_sec']); 

$long_deg = mysqli_real_escape_string($con1, $_POST['long_deg']); 
$long_min = mysqli_real_escape_string($con1, $_POST['long_min']); 
$long_sec = mysqli_real_escape_string($con1, $_POST['long_sec']); 

$province = mysqli_real_escape_string($con1, $_POST['proveng']);
$county = mysqli_real_escape_string($con1, $_POST['countyeng']); 
$bag = mysqli_real_escape_string($con1, $_POST['bageng']); 
$Other = mysqli_real_escape_string($con1, $_POST['Other']); 

$datepicked=$_POST['pickeddate'];
$Diagnostic_date = mysqli_real_escape_string($con1, $datepicked); 

$New_additional_occurance = mysqli_real_escape_string($con1, $_POST['New_additional_occurance']); 
$Disease_occurred_species = mysqli_real_escape_string($con1, $_POST['Disease_occurred_species']); 
$Breed = mysqli_real_escape_string($con1, $_POST['Breed']); 
$Diagnosis = mysqli_real_escape_string($con1, $_POST['Diagnosis']); 
$Note = mysqli_real_escape_string($con1, $_POST['Note']); 

$Livestock_population = mysqli_real_escape_string($con1, $_POST['Livestock_population']); 
$Cases = mysqli_real_escape_string($con1, $_POST['Cases']); 
$Deaths = mysqli_real_escape_string($con1, $_POST['Deaths']); 

$nsheep = mysqli_real_escape_string($con1, $_POST['nsheep']); 
$ngoat = mysqli_real_escape_string($con1, $_POST['ngoat']); 
$ncattle = mysqli_real_escape_string($con1, $_POST['ncattle']); 
$nhorse = mysqli_real_escape_string($con1, $_POST['nhorse']); 
$ncamel = mysqli_real_escape_string($con1, $_POST['ncamel']); 
$nreindeer = mysqli_real_escape_string($con1, $_POST['nreindeer']); 
$npig = mysqli_real_escape_string($con1, $_POST['npig']); 
$nchicken = mysqli_real_escape_string($con1, $_POST['nchicken']); 
$nothers = mysqli_real_escape_string($con1, $_POST['nothers']); 

$bin = openssl_random_pseudo_bytes(20);
$footprint=bin2hex($bin);
//$_SESSION['footprint']=$footprint;

$footprint=mysqli_real_escape_string($con1, $footprint ); 
//echo $footprint;

$sql1="UPDATE disease SET Owners_name='$Owners_name', lat_deg='$lat_deg', lat_min='$lat_min', lat_sec='$lat_sec', long_deg='$long_deg', long_min='$long_min', long_sec='$long_sec', province='$province', county='$county', bag='$bag', Other='$Other', Diagnostic_date='$Diagnostic_date', New_additional_occurance='$New_additional_occurance', Disease_occurred_species='$Disease_occurred_species', Breed='$Breed', Note='$Note', Diagnosis='$Diagnosis', Livestock_population='$Livestock_population', Cases='$Cases', Deaths='$Deaths', nsheep='$nsheep', ngoat='$ngoat', ncattle='$ncattle', nhorse='$nhorse', ncamel='$ncamel', nreindeer='$nreindeer', npig='$npig', nchicken='$nchicken', nothers='$nothers', footprint='$footprint' WHERE  PID='$pid' ";



if (!mysqli_query($con1,$sql1)) {
die('Error: ' . mysqli_error($con1));
}
//echo "1 record added";
mysqli_close($con1);

$PHPtext = "Your PHP alert!";

?>

<script>
/*
var JavaScriptAlert = <?php echo json_encode($_POST['nsheep']); ?>;
alert(JavaScriptAlert); // Your PHP alert!
*/
</script>

<script language='javascript'>
<?
	$actstring="ReviewCheckData.html"."?pid=".$pid;
?>
	//window.alert('<?=$row['id']?> is connected now ')
	location.replace('<? echo $actstring;?>')
</script>



</body>
</html>