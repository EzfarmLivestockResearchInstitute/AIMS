
<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}
	$sessvar=$_SESSION['lang'];
	
	function selectwords($connect, $langnum, $serialnum) {
	$sql="select WORDS from languages where LANG=$langnum and SERIAL_NUM='$serialnum' ";
	$result=mysqli_query($connect, $sql);
	$img=mysqli_fetch_assoc($result);
	$lang=$img['WORDS']; 
	return $lang;
}		
include('./connectdb.php'); 
$connect = dbconect();

?>


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

$con1 = dbconect();

// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// SQL INJECTION escape

$id = mysqli_real_escape_string($con1, $_POST['id']); 	//넘어온 아이디
$pass1 = mysqli_real_escape_string($con1, $_POST['pass1']);
$pass2 = mysqli_real_escape_string($con1, $_POST['pass2']);
$user_name = mysqli_real_escape_string($con1, $_POST['name']);
$affiliation = mysqli_real_escape_string($con1, $_POST['affiliation']);
$email = mysqli_real_escape_string($con1,  $_POST['email']);

//$nameadd=$_POST['nameadd'];
//$name = mysqli_real_escape_string($con1, $nameadd);

//아이디 중복 검사
$idq='"'.$id.'"';
$sql1="select* from regist where id=$idq";
$result=mysqli_query($con1,$sql1);
$cnt=mysqli_num_rows($result);



if ( !$id ) {//아이디는 공란이 될 수 없습니다!
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0238')."'".");
	history.go(-1);
	</script>";
	exit(1);  
} elseif ($cnt>0) {//이미 사용중인 아이디입니다.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0239')."'".");
	history.go(-1);
	</script>";
	exit(1);
} elseif (!preg_match("/^[a-zA-Z][a-zA-Z0-9]{3,14}$/",$_POST['id'])) {//아이디는 4자 이상으로 입력해주십시오.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0240').$id.preg_match("/^[a-zA-Z][a-zA-Z0-9]{3,14}$/",$_POST['id'])."'".");
	history.go(-1);
	</script>";
	exit(1);  
} elseif ( !$pass1 ) {//비밀번호는 공란이 될 수 없습니다.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0241')."'".");
	history.go(-1);
	</script>";
	exit(1);  
} elseif (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{3,14}$/",$_POST['pass1'])){//비밀번호를 형식에 맞게 다시 설정해주세요.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0229')."'".");
	history.go(-1);
	</script>";
	exit(1);  
} elseif ( $pass1 != $pass2 ) {//설정할 비밀번호가 일치하지 않습니다.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0242')."'".");
	history.go(-1);
	</script>";
	exit(1);  
} else {//가입신청이 완료되었습니다.

	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0243')."'".")
	location.replace('./index.html')
	</script>";

}

$time= date('m/d/Y h:i:s a', time());

mysqli_query($con1,"insert into regist (id, pass1, pass2, name, inputdate, affiliation, member_se, email) values ('$id', '$pass1', '$pass2', '$user_name', '$time', '$affiliation', 'W', '$email')");
//mysqli_query($con1,"UPDATE regist SET id='$id', pass1='$pass1', pass2='$pass2', inputdate='$time', affiliation='$affiliation', member_se = 'W' WHERE email='$email'");
mysqli_close($con1);
?>


</body>
</html>