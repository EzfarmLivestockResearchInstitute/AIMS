<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

$name=$_SESSION['user_id'];
$sessvar=$_SESSION['lang'];

$pid=$_GET['pid'];
$pidco=$_GET['pidco'];
$aaa=$_GET['aaa'];
$count=$_GET['count'];

//echo '원글의pid : '.$pid."<br>";
//echo '구분자 : '.$aaa."<br>".'글 내용 : '.$_POST['comment']."<br>".'댓글의pid : '.$pidco."<br>".'바뀐댓글내용 : '.$_POST['commo']."<br>".'조회수 : '.$count;


?>

<!DOCTIME html>
<html>
<head>
<meta charset="utf-8">
<title> M-AIMS M
anagement Tree </title>
<!--
<link href="style.css" rel="stylesheet"/>
-->
<style type="text/css">a {text-decoration: none}</style>

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
   include('connectdb.php'); 
   $con1 = dbconect();

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// SQL INJECTION escape

$layer=mysqli_real_escape_string($con1, $_POST['colayer']);

$LinkedID = mysqli_real_escape_string($con1, $_POST['coLinkedID']); //연결번호

/*$title = mysqli_real_escape_string($con1, $_POST['title']);*/ //제목
$contents = mysqli_real_escape_string($con1, $_POST['comment']); //내용
$commo=mysqli_real_escape_string($con1, $_POST['commo']);//수정된 댓글의 내용
/*
$hits = mysqli_real_escape_string($con1, $_POST['hits']); 
*/

if($aaa==0){
	$sql1="INSERT INTO board (layer,name,LinkedID,contents) VALUES ('$layer','$name','$LinkedID','$contents')";

	if (!mysqli_query($con1,$sql1)) {
	die('Error: ' . mysqli_error($con1));
	}
}

if($aaa==1){
	$sql2="UPDATE board SET layer='$layer',name='$name',LinkedID='$LinkedID',contents='$commo' WHERE PID='$pidco' ";
	if (!mysqli_query($con1,$sql2)) {
	die('Error: ' . mysqli_error($con1));
	}
}


//echo "1 record added";

mysqli_close($con1);

$PHPtext = "Your PHP alert!";

?>

<?php
/*
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
*/
?>


<A HREF="board.html"><br>게시글 목록으로 이동<br></A>
		

		
</body>
</html>