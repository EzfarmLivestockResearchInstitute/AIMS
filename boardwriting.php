<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

	$user_id=$_SESSION['user_id'];
	$sessvar=$_SESSION['lang'];
	// SQL INJECTION escape
	$flagwrite=$_POST['flagwrite'];//머리 게시글 여부 
	
	//echo $flagwrite.'나오라고'; 			
?>

<html lang="ko">
<head>
<meta charset="utf-8">
<title> TEST </title>
<link href="style.css" rel="stylesheet"/>
<style type="text/css">a {text-decoration: none}</style>



<script language='javascript'>
	var str
	str='<? echo  "$flagwrite"; ?>'
	location.replace('board.html?flagwrite='+str)
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


$layer=mysqli_real_escape_string($con1, $_POST['layer']);

$LinkedID = mysqli_real_escape_string($con1, $_POST['LinkedID']); //연결번호
$name=$user_id;//글쓴이
//$_SESSION['user_id']=$name;//글쓴이

$title = mysqli_real_escape_string($con1, $_POST['title']); //제목
$contents = mysqli_real_escape_string($con1, $_POST['contents']); //내용
/*
$hits = mysqli_real_escape_string($con1, $_POST['hits']); 
*/

/* 개발서버 새팅 후 insert 구문에 num,tits 컬럼 추가 값 0 세팅 
   2017.06.26 RED   
*/    
$sql1="INSERT INTO board (layer,name,title,contents,num,hits)
VALUES ('$layer','$name','$title','$contents','0','0')";
   
if (!mysqli_query($con1,$sql1)) {
die('Error: ' . mysqli_error($con1));
}
echo "1 record added";
mysqli_close($con1);

$PHPtext = "Your PHP alert!";

?>

<?php
include('connectdb.php'); 
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