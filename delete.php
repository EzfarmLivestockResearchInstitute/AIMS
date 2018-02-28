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

$user_id = mysqli_real_escape_string($con, $_POST['id']);
$user_name = mysqli_real_escape_string($con, $_POST['name']);
$user_pass1 =mysqli_real_escape_string($con, $_POST['pass1']);
$user_email = mysqli_real_escape_string($con, $_POST['email']);

$query="SELECT * FROM regist WHERE id='{$user_id}' AND name='{$user_name}' AND pass1='{$user_pass1}' AND email='{$user_email}'";
$data=mysqli_query($con,$query);


if(mysqli_num_rows($data)<1){//회원님의 정보가 기존정보와 일치하지 않습니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0234')."'".")
	history.go(-1)
	</script>";
	exit(1);
}
else {//회원님은 탈퇴되셨습니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0235')."'".")
	location.replace('./index.html')
	</script>";
}
$row=mysqli_fetch_array($data);


mysqli_query($con,"DELETE FROM regist  WHERE id='{$user_id}' AND pass1='{$user_pass1}'  ");

mysqli_close($con);
?> 

<script language='javascript'>
	window.alert('<?=$row['id']?>님은 탈퇴되셨습니다.')
	location.replace('./index.html')
</script>
</body>
</html>
