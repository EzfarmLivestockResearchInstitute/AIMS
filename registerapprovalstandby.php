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
<link rel="stylesheet" type="text/css" href="./css/admin.css">
<link rel="stylesheet" type="text/css" href="./css/button_admin.css">

<!--- 추가 start -->
<!-- jQuery -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js" type="text/javascript"></script>

<!-- css & bootstrap -->
<link rel="stylesheet" type="text/css" href="./css/my_style.css" />
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css" />
<script type="text/javascript" src="./js/bootstrap/bootstrap.min.js"></script>
<!--- 추가 end -->


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
$result = mysqli_query($con1,"SELECT * FROM regist where id is not null");
echo '<div class="tbl_list">
		<table class="table" style="word-break:break-all">
		<thead>
<tr>
<th class="col-xs-2">'.selectwords($connect, $_SESSION['lang'], 'a0014').'</th><!--아이디 -->
<th class="col-xs-2">'.selectwords($connect, $_SESSION['lang'], 'a0015').'</th><!--비밀번호-->
<th class="col-xs-1">'.selectwords($connect, $_SESSION['lang'], 'a0177').'</th><!--이름 -->
<th class="col-xs-3">'.selectwords($connect, $_SESSION['lang'], 'a0176').'</th><!--이메일 -->
<th class="col-xs-1">'.selectwords($connect, $_SESSION['lang'], 'a0179').'</th><!--소속 -->
<th class="col-xs-2">'.selectwords($connect, $_SESSION['lang'], 'a0210').'</th><!--가입요청날짜-->
<th class="col-xs-1"></th><!--가입경로-->
<!--<th>'.selectwords($connect, $_SESSION['lang'], 'a0223').'</th>승인여부-->
<!--<th>'.selectwords($connect, $_SESSION['lang'], 'a0224').'</th><!--승인날짜-->
<!--<th>'.selectwords($connect, $_SESSION['lang'], 'a0225').'</th><!--승인취소날짜-->
</tr>
</thead>
<tbody>';

$ty = "";
while($row = mysqli_fetch_array($result)) {
echo "<tr>";
echo "<td class='col-xs-2'>" . $row['id'] . "</td>";
echo "<td class='col-xs-2'>" . $row['pass1'] . "</td>";
echo "<td class='col-xs-1'>" . $row['name'] . "</td>";
echo "<td class='col-xs-3'>" . $row['email'] . "</td>";
echo "<td class='col-xs-1'>" . $row['affiliation'] . "</td>";
echo "<td class='col-xs-2'>" . $row['inputdate'] . "</td>";
if ($row['member_se'] == 'W') $ty = "Web Program";
else $ty = "Mobile Program";
echo "<td class='col-xs-1'>" .$ty. "</td>";
//echo "<td align='center'>" . $row['approved'] . "</td>";
//echo "<td>" . $row['approveddate'] . "</td>";
//echo "<td>" . $row['approvedcanceldate'] . "</td>";
//echo "</tr>";
}
echo "</tbody></table></div>";
mysqli_close($con1);

?>
 
<div class="gridTop">
	<div class="grdBtnR">
		<!--<span class="btn_gtGray w100"><a href="registerapproval.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0207'); ?></a></span>
		 <span class="btn_gtGray w100"><a href="registerapprovalcancel.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0208'); ?></a></span> -->
		<span class="btn_gtGray w100"><a href="registerAdminauth.php"> <? echo selectwords($connect, $_SESSION['lang'], 'a0246'); ?> </a></span>
	</div>
</div>

</body>
</html>