<?php
session_start();
$id=$_SESSION['user_id'];


if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

$sessvar=$_SESSION['lang'];

//언어함수
function selectwords($connect, $langnum, $serialnum) {
	$sql="select WORDS from languages where LANG=$langnum and SERIAL_NUM='$serialnum' ";
	$result=mysqli_query($connect, $sql);
	$img=mysqli_fetch_assoc($result);
	$lang=$img['WORDS']; 
	return $lang;
}
?>

<? 
	//require "connectdb.php"; 
	include('connectdb.php'); 
    $connect = dbconect();
?>
<? require "config.php"; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html" charset="utf-8">
<script type="text/javascript">
var sURL = unescape(window.location.pathname);// 현재의 페이지를 언어만 변경 후 다시 열기

//언어 변경 함수 
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

$con = dbconect();

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$id=$_POST['id'];
$user_id = mysqli_real_escape_string($con,$id);

$user_newaffiliation=mysqli_real_escape_string($con, $_POST['n_affiliation']);

if ( !$user_newaffiliation) {//새로 설정할 소속은 공란이 될 수 없습니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0233')."'".")
	history.go(-1)
	</script>";	
	exit(1);  
	}
else {//회원님의 소속이 성공적으로 변경되었습니다.

	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0222')."'".")
	location.replace('personalinformation.html')
	</script>";

}
$query="SELECT * FROM regist WHERE id='{$user_id}' ";
$data=mysqli_query($con,$query);
$row=mysqli_fetch_array($data);

mysqli_query($con,"UPDATE regist SET affiliation='{$user_newaffiliation}' WHERE id='{$user_id}'  ");


mysqli_close($con);
?> 

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?=$row['id']?><? echo selectwords($connect, $_SESSION['lang'], 'a0222'); ?><!--님의 소속이 변경되었습니다.--><br>
<br><br>
<A HREF="personalinformation.html"><? echo selectwords($connect, $_SESSION['lang'], 'a0214'); ?><!--개인정보관리로 이동--></A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="http://m-aims.net/page2.html"><? echo selectwords($connect, $_SESSION['lang'], 'a0095'); ?><!--홈으로 이동--></A>
</body>
</html>