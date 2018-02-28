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
$con = dbconect();

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$user_name =mysqli_real_escape_string($con, $_POST['name']);
$user_email = mysqli_real_escape_string($con, $_POST['email']);


$query="SELECT * FROM regist WHERE name='{$user_name}' AND email='{$user_email}'";
$data=mysqli_query($con,$query);


if(mysqli_num_rows($data)<1){//회원이 아닙니다!
	echo "<script>
	window.alert("."'".selectwords($connect, $sessvar, 'a0244')."'".")
	history.go(-1);
	</script>";
	exit(1);  
}

$row=mysqli_fetch_array($data);

mysqli_close($con);
?> 

<script language='javascript'>
	window.alert('<?=$row['name']?>님의 아이디는 "<?=$row['id']?>"입니다.')
	location.replace('./index.html')
</script>
</body>
</html>
