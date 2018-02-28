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

	//require "connectdb.php"; 
	include('connectdb.php'); 
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
$con = dbconect();

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$idadd=$_POST['idadd'];
$user_id = mysqli_real_escape_string($con, $idadd);
//$user_id = mysqli_real_escape_string($con, $_POST['id']);
$user_newpass1=mysqli_real_escape_string($con, $_POST['n_pass1']);
$user_newpass2=mysqli_real_escape_string($con, $_POST['n_pass2']);

$idq='"'.$user_id.'"';
$sql1="select* from regist where id=$idq";
$result=mysqli_query($con,$sql1);
if ( !$user_newpass1 ) {
	echo "<script>
	window.alert('비번은 공란이 될 수 없습니다.')
	history.go(-1)
	</script>";
	exit(1);  
	}
elseif (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{4,14}$/",$_POST['n_pass1'])){////비밀번호를 형식에 맞게 다시 설정해주세요.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0229')."'".")
	history.go(-1)
	</script>";
	exit(1);   
	}
elseif ( $user_newpass1 != $user_newpass2 ) {////설정할 비밀번호가 일치하지 않습니다.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0242')."'".")
	history.go(-1)
	</script>";
	exit(1); 
	}
else{//회원님의 비밀번호가 성공적으로 변경되었습니다.
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0216')."'".");
	location.replace('http://m-aims.net');
	</script>";

}
$query="SELECT * FROM regist WHERE id='{$user_id}'";
$data=mysqli_query($con,$query);
$row=mysqli_fetch_array($data);

mysqli_query($con,"UPDATE regist SET pass1='{$user_newpass1}' WHERE id='{$user_id}'  ");
mysqli_query($con,"UPDATE regist SET pass2='{$user_newpass2}' WHERE id='{$user_id}'  ");


mysqli_close($con);
?> 


</body>
</html>