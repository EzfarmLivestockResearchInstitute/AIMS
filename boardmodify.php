<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

	//$_SESSION['user_id']=$user_id;
	$user_id = $_SESSION['user_id'];
	$sessvar=$_SESSION['lang'];
	
	$count=$_GET['count'];
	$pid=$_GET['pid'];
	//echo '이 글의 pid : '.$pid.'이 글의 조회수 : '.$count;

//언어함수 
function selectwords($con1, $langnum, $serialnum) {
	$sql="select WORDS from languages where LANG=$langnum and SERIAL_NUM='$serialnum' ";
	$result=mysqli_query($con1, $sql);
	$img=mysqli_fetch_assoc($result);
	$lang=$img['WORDS']; 
	return $lang;
}

// 언어 사전 검색 
function select_str_word($con1, $langnum, $breed) {
	$sql="select SERIAL_NUM from languages where WORDS='$breed' ";
	$result=mysqli_query($con1, $sql);
	$img=mysqli_fetch_assoc($result);
	$serialnum=$img['SERIAL_NUM']; 
	$lang=selectwords($con1, $langnum, $serialnum); 
	return $lang;
}
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

<?php
	$boardview='boardview.html'.'?pid='.$pid.'&count='.$count;
?>

<script language='javascript'>
	//window.alert('<?=$row['id']?> is connected now ')
	location.replace('<? echo $boardview; ?>')
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

$layer=mysqli_real_escape_string($con1, $_POST['layer']);

$LinkedID = mysqli_real_escape_string($con1, $_POST['LinkedID']); //연결번호

$name = mysqli_real_escape_string($con1, $_POST['name']); //연결번호
//$_SESSION['user_id']=$name;//글쓴이

$title = mysqli_real_escape_string($con1, $_POST['title']); //제목
$contents = mysqli_real_escape_string($con1, $_POST['contents']); //내용
/*
$hits = mysqli_real_escape_string($con1, $_POST['hits']); 
*/

$sql1="UPDATE board SET layer='$layer',name='$user_id',title='$title',contents='$contents',hits='$count' WHERE PID='$pid' ";

if (!mysqli_query($con1,$sql1)) {
die('Error: ' . mysqli_error($con1));
}
echo "1 record added";
mysqli_close($con1);

$PHPtext = "Your PHP alert!";

?>

<?php
$con1 = dbconect();

// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con1,"SELECT * FROM board where DeleteOrNot=1");
echo "<table border='1'>
<tr>
<th>layer</th>
<th>고유번호</th>
<th>연결번호</th>
<th>글쓴이</th>
<th>제목</th>
<th>내용</th>
<th>게시날짜</th>
<th>조회수</th>
<th>삭제여부</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
echo "<tr>";
echo "<td>" . $row['layer'] . "</td>";
echo "<td>" . $row['PID'] . "</td>";
echo "<td>" . $row['LinkedID'] . "</td>";
echo "<td>" . $row['name'] . "</td>";
echo "<td>" . $row['title'] . "</td>";
echo "<td>" . $row['contents'] . "</td>";
echo "<td>" . $row['posteddate'] . "</td>";
echo "<td>" . $row['hits'] . "</td>";
echo "<td>" . $row['DeleteOrNot'] . "</td>";
echo "</tr>";
}
echo "</table>";
mysqli_close($con1);
?>


</body>
</html>