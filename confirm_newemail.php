<? @session_start();
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

<?php
$con = dbconect();

$id=$_POST['id'];
$user_id = mysqli_real_escape_string($con,$id);
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user_email = mysqli_real_escape_string($con, $_POST['n_email']);

//이메일 중복 검사
$user_emailq='"'.$user_email.'"';
$sql1="select* from regist where email=$user_emailq";
//echo 'sql1='.$sql1.'<br>';
$result=mysqli_query($con,$sql1);
$cnt=mysqli_num_rows($result);
//echo 'aaa'.$cnt.'<br>';
//printf("Result set has %d rows.\n", $cnt);

if ( !$user_email ) {//새로 설정할 이메일을 입력해주세요!
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0217')."'".")
	history.go(-1)
	</script>";	
	exit(1);  
	}
elseif($cnt>0){//이미 사용중인 이메일 입니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0218')."'".")
	history.go(-1)
	</script>";	
	exit(1);
	}
elseif (!filter_var($_POST['n_email'], FILTER_VALIDATE_EMAIL)) {//올바른 이메일 주소가 아닙니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0219')."'".")
	history.go(-1)
	</script>";	
	exit(1);  
	}
else {
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0215')."'".")
	location.replace('personalinformation.html')
	</script>";
}
$query="SELECT * FROM regist WHERE id='{$user_id}' ";
$data=mysqli_query($con,$query);
$row=mysqli_fetch_array($data);

mysqli_query($con,"UPDATE regist SET email='{$user_email}' WHERE id='{$user_id}'  ");

mysqli_close($con);

?> 

<body>
<?=$row['id']?><? echo selectwords($connect, $_SESSION['lang'], 'a0215'); ?><!--님 이름이 변경되었습니다.--><br>
<br>
<br>
<A HREF="personalinformation.html"><? echo selectwords($connect, $_SESSION['lang'], 'a0214'); ?><!--개인정보관리로 이동--></A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="./page2.html"><? echo selectwords($connect, $_SESSION['lang'], 'a0095'); ?><!--홈으로 이동--></A>
</body>
</html>