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
    		document.location.reload(true);
			//상태 4인 경우 데이터를 받기
	//		var myObject = JSON.parse(httpxml.responseText); 
		//	alert("aaa");
		//	alert(httpxml.responseText);
		} // END: if(httpxml.readyState==4) 
	} // END: function provengChanged()

	// 데이터베이스에서 자료 가지고 오기 위한 준비
	var url="membercancel.php";
	
	url+="?dvar=111";
	url+=checkedIdString;
	url=url+"&randid="+Math.random();

	// 상태가 바뀌면 이 함수를 실행  
	httpxml.onreadystatechange=stateChanged; 
	
	//비동기 통신 방식으로 url을 보내서 실행
	httpxml.open("GET",url,true);
	httpxml.send();
	//httpxml.send(jasonString);
	
}// end of ajaxFunction(choice) 

function oddunhamsu() {
   	var checkedval = [];
   	var checkedidnameval=[];
	var checkedboxes = document.getElementsByName("checked[]");
	var checkedboxes02 = document.getElementsByName("idname[]");
	
	var checkedIdString ="";
	var k=-1;
	
	for(var i = 0; i < checkedboxes.length; i++){
	   	if (checkedboxes[i].checked) {
			k+=1;
			//checkedval.push(checkedboxes[i].value);		
			checkedidnameval.push(checkedboxes02[i].value);	
			var tstr = checkedidnameval.pop();
			checkedIdString += "&idstring"+k+"="+tstr;
		}
  	    dvnum="dvnum"+i;
  	   // document.getElementById(dvnum).innerHTML=i+" "+checkedval.pop()+" "+tstr;//checkedboxes02[i].id;
	}
	//var jsonString = JSON.stringify(checkedidnameval);
	k+=1;
	checkedIdString=checkedIdString+"&length="+k;
	ajaxFunction(checkedIdString);
	
	// window.location.href = 'aaa.php';
}
</script>
 
 
    
<?php

$con1 = dbconect();

// Check connection
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con1,"SELECT * FROM regist where approved=1");
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
	<tbody>
	<tr>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0014'); ?><!--아이디 --></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0015'); ?><!--비밀번호--></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0177'); ?><!--이름 --></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0176'); ?><!--이메일 --></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0179'); ?><!--소속 --></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0210'); ?><!--가입요청날짜 --></th>
		<th><? echo selectwords($connect, $_SESSION['lang'], 'a0211'); ?><!--승인취소 --></th>
	</tr>
<?
$i=1;
while($row = mysqli_fetch_array($result)) {
	$name="checked[]";
	$idname="idname[]";
	//$i=$i+1;
?>
	<tr>
		<td>  <? echo $row['id']?>
		<? echo '<input type="hidden" name="'.$idname.'"value ="'.$row['id'].'">'?> </td>
		<td>  <? echo $row['pass1']?> </td>
		<td>  <? echo $row['name']?> </td>
		<td>  <? echo $row['email']?> </td>
		<td>  <? echo $row['affiliation']?> </td>
		<td>  <? echo $row['inputdate']?> </td>
		<td align='center'>  <? echo '<input type="checkbox" name="'.$name.'"value="1" > ' ?></td>
	</tr>
<?
}
?>
</tbody></table></div>
<?
mysqli_close($con1);
?>


<!--<input type="checkbox" name="myname[]" value="1" checked="checked"/> 
<input type="checkbox" name="myname[]" value="1" />
<input type="checkbox" name="myname[]" value="1" />
<input type="checkbox" name="myname[]" value="1" />
<input type="checkbox" name="myname[]" value="1" />-->

<div class="gridTop">
	<div class="grdBtnR">
		<!--<input type=submit class="btn_gtBlue w80" value="<? echo selectwords($connect, $_SESSION['lang'], 'a0022'); ?>" onclick="oddunhamsu(); return false;" >-->
		<span class="btn_gtBlue w100"><a href='#' onclick="oddunhamsu(); return false;"><? echo selectwords($connect, $_SESSION['lang'], 'a0022'); ?></a></span><!--submit버튼-->	
	</div>
</div>
<div class="gridTop">
	<div class="grdBtnR">
		<span class="btn_gtGray w100"><a href="registerapprovalstandby.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0170'); ?></a></span>
		<span class="btn_gtGray w100"><a href="registerapproval.php"><? echo selectwords($connect, $_SESSION['lang'], 'a0207'); ?></a></span>
		<span class="btn_gtGray w100"><a href="registerAdminauth.php"> <? echo selectwords($connect, $_SESSION['lang'], 'a0246'); ?> </a></span>
	</div>
</div>

</form>

<!--
<div id="dvnum0" style="width: 400px; height: 20px;"></div>
<div id="dvnum1" style="width: 400px; height: 20px;"></div>
<div id="dvnum2" style="width: 400px; height: 20px;"></div>
<div id="dvnum3" style="width: 400px; height: 20px;"></div>
<div id="dvnum4" style="width: 400px; height: 20px;"></div>
<div id="dvnum5" style="width: 400px; height: 20px;"></div>
<div id="dvnum6" style="width: 400px; height: 20px;"></div>
<div id="dvnum7" style="width: 400px; height: 20px;"></div>
<div id="dvnum8" style="width: 400px; height: 20px;"></div>
<div id="dvnum9" style="width: 400px; height: 20px;"></div>
<div id="dvnum10" style="width: 400px; height: 20px;"></div>
<div id="dvnum11" style="width: 400px; height: 20px;"></div>
<div id="dvnum12" style="width: 400px; height: 20px;"></div>
<div id="dvnum13" style="width: 400px; height: 20px;"></div>
<div id="dvnum14" style="width: 400px; height: 20px;"></div>
<div id="dvnum15" style="width: 400px; height: 20px;"></div>
<div id="dvnum16" style="width: 400px; height: 20px;"></div>
<div id="dvnum17" style="width: 400px; height: 20px;"></div>
<div id="dvnum18" style="width: 400px; height: 20px;"></div>
<div id="dvnum19" style="width: 400px; height: 20px;"></div>
<div id="dvnum20" style="width: 400px; height: 20px;"></div>
<div id="dvnum21" style="width: 400px; height: 20px;"></div>
<div id="dvnum22" style="width: 400px; height: 20px;"></div>
<div id="dvnum23" style="width: 400px; height: 20px;"></div>
<div id="dvnum24" style="width: 400px; height: 20px;"></div>
<div id="dvnum25" style="width: 400px; height: 20px;"></div>
-->
</body>
</html>