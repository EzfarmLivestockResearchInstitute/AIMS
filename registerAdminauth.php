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
	include('connectdb.php'); 
    $connect = dbconect();

?>
<? require "config.php"; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="./css/admin.css">
<link rel="stylesheet" type="text/css" href="./css/button_admin.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>
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
<script>
function ajaxFunction(checkedIdString) {
   	//document.getElementById("dvnum0").innerHTML=checkedIdString;

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
    		alert("Data has been saved successfully.");
			document.location.reload(true);
			//상태 4인 경우 데이터를 받기
	//		var myObject = JSON.parse(httpxml.responseText); 
		//	alert("aaa");
		//	alert(httpxml.responseText);
		} // END: if(httpxml.readyState==4) 
	} // END: function provengChanged()

	// 데이터베이스에서 자료 가지고 오기 위한 준비
	var url="admiapprove.php";
	
	url+=checkedIdString;
	// 상태가 바뀌면 이 함수를 실행  
	httpxml.onreadystatechange=stateChanged; 
	
	//비동기 통신 방식으로 url을 보내서 실행
	httpxml.open("GET",url,true);
	httpxml.send();
	//httpxml.send(jasonString);
	
}// end of ajaxFunction(choice) 
function oddunhamsu() {
 	var len= 0;
	var param = "&";
	var checkedval = [];
	
	var len1= 0;
	var param1 = "&";
	var checkedval1 = [];
	
	$('.modFlag').each(function(idx){
		if ($(this).val() != '')
		{
			if(param.length == 1) {
				param += 'id' + len + '=' + $(this).attr("id");
			} else {
				param += '&id' + len + '=' + $(this).attr("id");
			}

			param += '&val' + (len++) + '=' + $(this).val();
		}
	});
//alert(param);
	$('.modFlag1').each(function(idx){
		if ($(this).val() != '0')
		{
			if(param1.length == 1) {
				param1 += 'idd' + len1 + '=' + $(this).attr("id");
			} else {
				param1 += '&idd' + len1 + '=' + $(this).attr("id");
			}

			if ($(this).val() == '1') {
				param1 += '&vall' + (len1++) + '=1';
			} else {
				param1 += '&vall' + (len1++) + '=0';
			}
		}
	});
//alert(param1);
	
	var sndParam = "";
	
	if(len == 0 && len1 == 0) {
		  alert("변견된 사항이 없습니다.");
		  return false;
	}
	
	sndParam = "?length=" + len + param + "&length1=" + len1 + param1 ;
//alert(sndParam);
	ajaxFunction(sndParam);
}

function fnModfied(id, obj){
//alert(id + '-' + obj.value);
	$('#' + id).val(obj.value);
}

function fnModfied1(id, obj){
	if ($(obj).is(":checked"))	{
		$('#' + id+ 1).val('1');
	} else {
		$('#' + id+ 1).val('9');
	}

}
</script>

<?php
$con1 = dbconect();

// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con1,"SELECT * FROM regist where id is not null");
?>
<form >
<div class="tbl_list">
	<table>
		<col width="150px">
		<col width="150px">
		<col width="150px">
		<col width="250px">
		<col width="250px">
		<col width="100px">
		<col width="100px">
		<col width="100px">
		<tbody>
			<tr>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0014'); ?><!--아이디 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0015'); ?><!--비밀번호--></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0177'); ?><!--이름 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0176'); ?><!--이메일 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0179'); ?><!--소속 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0210'); ?><!--가입요청날짜 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0006'); ?><!--관리자 --></th>
				<th><? echo selectwords($connect, $_SESSION['lang'], 'a0223'); ?><!--승인여부 --></th>
			</tr>
			<?
			$i=1;
			while($row = mysqli_fetch_array($result)) {
				$name="checked[]";
				//$class="class[]";
				$idname="idname[]";
				
				$name1="checked[]";
				$idname1="idname[]";
				//$i=$i+1;
			?>

			<tr>
			 <td>  <? echo $row['id']?>
			<? echo '<input type="hidden" class="modFlag" id="'.$row['id'].'" value ="0" />'?>
			<? echo '<input type="hidden" class="modFlag1" id="'.$row['id'].'1" value ="0" />'?>
			 </td>
				<td>  <? echo $row['pass1']?> </td>
				<td>  <? echo $row['name']?> </td>
				<td>  <? echo $row['email']?> </td>
				<td>  <? echo $row['affiliation']?> </td>
				<td>  <? echo $row['inputdate']?> </td>
				<td align='center'>  
				<?
					$flag0 = '';
					$flag1 = '';
					$flag2 = '';
					$flag3 = '';
					$flag4 = '';
					$flag5 = '';
					
					if($row['flaguser'] == '1') $flag1 = "selected='true'";
					if($row['flaguser'] == '2') $flag2 = "selected='true'";
					if($row['flaguser'] == '3') $flag3 = "selected='true'";
					if($row['flaguser'] == '4') $flag4 = "selected='true'";
					if($row['flaguser'] == '0') $flag5 = "selected='true'";
					if($row['flaguser'] == '5') $flag6 = "selected='true'";

					echo "<select name='flaguser' class='w80' onchange='fnModfied(\"".$row[id]."\", this)'>";
					echo "	<option value='1'".$flag1.">chief veterinarian</option>";
					echo "	<option value='2'".$flag2.">director</option>";
					echo "	<option value='3'".$flag3.">head of division </option>";
					echo "	<option value='4'".$flag4.">expert veterinarian</option>";
					echo "	<option value='0'".$flag5.">Information veterinarian(admin)</option>";
					echo "	<option value='5'".$flag6.">qia</option>";
					echo "</select>";
				?>
				</td>
				<td align='center'>  
				<? 
					$flag1 = '';
					if($row['approved'] == '1') $flag1 = "checked='checked'";
					echo "<input type='checkbox'".$flag1." name='".$name1."'value='1' onchange='fnModfied1(\"".$row[id]."\", this)' />"; 
				?>
				</td>
			 </tr>
		<?
		}
		?>
		</tbody>
	</table>
</div>
<?
mysqli_close($con1);
?>

<div class="gridTop">
	<div class="grdBtnR">
		<!--<input type=submit class="btn_gtBlue w80" value="<? echo selectwords($connect, $_SESSION['lang'], 'a0022'); ?>" onclick="oddunhamsu(); return false;" >-->
		<span class="btn_gtBlue w100"><a href='#' onclick="oddunhamsu(); return false;"><? echo selectwords($connect, $_SESSION['lang'], 'a0022'); ?></a></span><!--submit버튼-->	
	</div>
</div>
<div class="gridTop">
	<div class="grdBtnR">
		<span class="btn_gtGray w100"><a href="registerapprovalstandby.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0170'); ?><!--회원명단 보기--></a></span>
		<!--<span class="btn_gtGray w100"><a href="registerapproval.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0207'); ?></a></span>
		<span class="btn_gtGray w100"><a href="registerapprovalcancel.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0208'); ?></a></span> -->
	</div>
</div>

</form>


</body>
</html>