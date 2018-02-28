<? @session_start();

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
$conn = dbconect();
$connect = dbconect();

// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// SQL INJECTION escape

$user_id = mysqli_real_escape_string($conn, $_POST['id']);
$user_pass1 =mysqli_real_escape_string($conn, $_POST['pass1']);
$url=$_REQUEST['url'];
//일치하는 아이디, 비번 찾기

$query="SELECT * FROM regist WHERE id='{$user_id}' AND pass1='{$user_pass1}' AND member_se = 'W' AND approved = 1";
$data=mysqli_query($conn,$query);

if(mysqli_num_rows($data)<1){
echo "<script language='javascript'>
	alert('".selectwords($connect, $sessvar, 'a0080')."');
	location.replace('/');
	</script>";
exit(1);

}

$row=mysqli_fetch_array($data);

$_SESSION['user_id']=$user_id;
$_SESSION['user_name']=$row['name'];
$_SESSION['adminYn']=$row['flaguser'];


?>

<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<script language='javascript'>
	window.alert("<?=$row['id']?> <?= selectwords($connect, $sessvar, 'a0026')?>");
	location.replace('page2.html');
</script>
</body>
</html>