<? 
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;

}	
	$user_id=$_SESSION['user_id'];
	$flagwrite = $_GET['flagwrite'];
	//echo "이게 나와야 하는디...".$flagwrite."<br>";
	$sessvar=$_SESSION['lang'];
	
	
	$curnum=$_GET['curnum'];
	//echo $flagwrite.'  '. $curnum. '<br>';
//언어함수
function selectwords($connect, $langnum, $serialnum) {
	$sql="select WORDS from languages where LANG=$langnum and SERIAL_NUM='$serialnum' ";
	$result=mysqli_query($connect, $sql);
	$img=mysqli_fetch_assoc($result);
	$lang=$img['WORDS']; 
	return $lang;
}
//% DB 연결
   include('connectdb.php'); 
   $connect = dbconect();

if(!$connect)
	die("DB 접속 실패: " .mysql_error());
//else
//	echo "Successful!";

?>

<?php
session_start();
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

	$user_id=$_SESSION['user_id'];
	$sessvar=$_SESSION['lang'];

$search=$_POST['search'];
$slsearch=$_POST['slsearch'];

//echo '검색어 : '.$search.'<br>';
//echo '검색항목 : '.$slsearch.'<br>';
?>

<html lang="ko">
<head>
<meta charset="utf-8">
<title> TEST </title>
<link rel="stylesheet" type="text/css" href="./css/admin.css">

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<script src="http://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>

<script>
function ajaxFunction(hamString) {
	var httpxml;
	try {
  		httpxml=new XMLHttpRequest(); // Firefox, Opera 8.0+, Safari
	}
	catch (e)  {
		try {
			httpxml=new ActiveXObject("Msxml2.XMLHTTP"); 
		}
		catch (e) {
			try {
				httpxml=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}

	// 이벤트 발생시 실행되는 함수 정의 
	function stateChanged() { 
		//alert(httpxml.readyState);
    	if(httpxml.readyState==4){
			//상태 4인 경우 데이터를 받기 
			//alert(httpxml.responseText);
			var myObject = JSON.parse(httpxml.responseText);
			var pid=myObject.value.pid;
			var flag=myObject.value.flag;
			var count=myObject.value.count;
			//document.getElementById("dvnum1").innerHTML=" pid="+pid+" flag="+flag;
			if(flag=='r'){
				window.location.href = 'boardview.html'+'?pid='+pid+'&count='+count;
			}
			else{
				location.reload();
			}

		} // END: if(httpxml.readyState==4) 
	} // END: function provengChanged()
	// 데이터베이스에서 자료 가지고 오기 위한 준비
	var url="boardassessment.php";
	
	url+=hamString;
	url=url+"&randid="+Math.random();

	// 상태가 바뀌면 이 함수를 실행  
	httpxml.onreadystatechange=stateChanged; 
	
	//비동기 통신 방식으로 url을 보내서 실행
	httpxml.open("GET",url,false);
	httpxml.send();
				

	//httpxml.send(jasonString);	
}// end of ajaxFunction(choice) 

function revimodirecord(idflag) {
	//document.getElementById("dvnum0").innerHTML=idflag;
	ajaxFunction(idflag);
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


if($slsearch == 'subject'){
	$condistring = "and title like"."'%".$search."%'";
}
if($slsearch == 'name'){
	$condistring = "and name like"."'%".$search."%'";
}
if($slsearch == 'num'){
	$condistring = "and num="."'".$search."'";
}
//echo '<br>'.$condistring.'<br>';

/* 2017.06.28 RED 쿼리 수정 및 함수추가*/
if($search == null)
{
	$condistring = "";
}
//$sql = "SELECT * FROM board where".$condistring." AND DeleteOrNot=1 AND layer=0";
$sql = "SELECT * FROM board where 1=1 AND DeleteOrNot=1 AND layer=0  ".$condistring." order by PID DESC";

	$result = mysqli_query($con1,$sql);

//	$result = mysqli_query($con1,"SELECT * FROM board where title='$search' AND DeleteOrNot=1");
	echo '<div class="tbl_list"><table>
			<thead>
				<tr>
					<th>'.selectwords($connect, $sessvar, "a0247").'</th>
					<th>'.selectwords($connect, $sessvar, "a0248").'</th>
					<th>'.selectwords($connect, $sessvar, "a0249").'</th>
					<th>'.selectwords($connect, $sessvar, "a0250").'</th>
					<th>'.selectwords($connect, $sessvar, "a0251").'</th>
				</tr>
			</thead><tbody>';
						
				while($row = mysqli_fetch_array($result)) {
						
					$pid=$row['PID'];
					$title = $row['title'];
					$name = $row['name']; 
					$posteddate = $row['posteddate'];
					$hits = $row['hits'];
					$layer =$row['layer'];
					$lid = $row['LinkedID'];
					$contents=$row['contents'];
					$count=$row['hits'];
					$num=$row['num'];

					$countsum=$count+1;

						echo "<tr>";
						echo '	<td align="center">'.$num.'</td>';
						
						//     제목 누르면 글로 넘어가기 
						$valStr='?pid='.$row['PID'].'&flag='.'r'.'&count='.$countsum; 
						$tmp1='<td align="center"> <a href="#Foo" onclick=" return revimodirecord(';
						$tmp2="'$valStr'";
						$tmp3=')">'.$title.'</a></td>';
						$tmp=$tmp1.$tmp2.$tmp3;
						echo $tmp;
						
						echo '	<td align="center">'.$name.'</td>
								<td align="center">'.$posteddate.'</td>
								<td align="center">'.$hits.'</td>
							</tr>';
					
				}	
				echo "</tbody></table></div>";
		mysqli_close($con1);
?>


</body>
</html>