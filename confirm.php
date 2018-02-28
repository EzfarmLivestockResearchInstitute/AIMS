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
$con = dbconect();
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
	$.get("./changelangsession.php", param, refreshpage);
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
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user_name =mysqli_real_escape_string($con, $_POST['name']);
$user_email = mysqli_real_escape_string($con, $_POST['email']);

//이메일 중복 검사
$user_emailq='"'.$user_email.'"';
$sql1="select* from regist where email=$user_emailq";

$result=mysqli_query($con,$sql1);
$cnt=mysqli_num_rows($result);

if (!$user_name){//이름을 입력해 주십시오.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0236')."'".");
	history.go(-1);
	return false;
	</script>";
	exit(1);  
	}
elseif ( !$user_email ) {//이메일을 입력해주세요!
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0237')."'".");
	history.go(-1);
	return false;
	</script>";
	exit(1);  
	}
elseif($cnt>0){//이미 사용중인 이메일 입니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0218')."'".");
	history.go(-1);
	return false;
	</script>";
	exit(1);  
	}

elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {//올바른 이메일 주소가 아닙니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0219')."'".");
	history.go(-1);
	return false;
	</script>";	
	exit(1);  
	}	
else {

}

$time= date('m/d/Y h:i:s a', time());
$sql2="INSERT INTO regist (name,email, initdate) VALUES ('$user_name','$user_email', '$time')";

if (!mysqli_query($con,$sql2)) {
	die('Error: ' . mysqli_error($con));
}
//echo "1 record added";


$sendername="aims.or.kr";

//$subj="Энэ нь таны мэдээллээ баталгаажуулах m-aims.net ирсэн и-мэйл юм. Дараах холбоосоор товшино уу!";
$subj="This is an email from m-aims.net to complete your applicaiton. Please click the link in the following.";

$message=" <a href='http://m-aims.net/register.html?mailadd=".$user_email."'";
$message.=" target=";
$message.="'_top'";
$message.=" >";
$message.="Нь memebership маягт бөглөж руу очих<br>Go to complete your application form <br>회원가입하러가기<br> </a>";//."&nameadd=".$user_name;
$mail_from = "webmaster@aims.or.kr";

//$from_name = '=?UTF-8?B?'.base64_encode($sendername).'?='; // 보내는사람 이름 
$from_name = $sendername; // 보내는사람 이름 
$mail_to = $_POST['email']; // 받는사람 메일주소 

$Headers = "MIME-Version: 1.0\r\n";
$Headers .= 'from: '.$from_name.' aaa '.$mail_from."\r\n";// from 과 : 은 붙여주세요 => from: 
$Headers .= "Content-Type: text/html; charset=utf-8\r\n"; // headers 에서 charset utf-8을 지정 

$subject = '=?UTF-8?B?'.base64_encode($subj).'?='; 
$contents01 =
		"From: ".$mail_from
		." of ".$sendername 
		."<br>"
		."<br>"
		.$message
		."<br>"
; 


$ret=mail($mail_to,$subject,$contents01,$Headers);
if ($ret){//이메일이 발송되었습니다.
 echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0220')."'".");
	location.replace('.index.html');
	</script>";
}
else {//이메일 주소가 올바르지 않아 발송이 실패되었습니다.
	echo "<script>
	window.alert("."'".selectwords($con, $sessvar, 'a0221')."'".");
	history.go(-1);
	</script>";
}

mysqli_close($con);
?> 

</body>
</html>
