<? 
session_start();
date_default_timezone_set('Asia/Seoul');
 
if(!isset($_SESSION['lang']) OR empty($_SESSION['lang']) ){
	$_SESSION['lang']=1;
}

$sessvar=$_SESSION['lang'];


if ( !isset($_SESSION['user_id']) OR empty($_SESSION['user_id']) ){
		echo "
		<script type=\"text/javascript\">
			window.location.href = '/index.html';
		</script>
	"; 
}
/*
if(!isset($_SESSION['psw']) OR empty($_SESSION['psw']) ){
		echo "
		<script type=\"text/javascript\">
			window.location.href = '/index.html';
		</script>
	"; 
}
*/

//언어함수
function selectwords($con1, $langnum, $serialnum) {
	$sql="select WORDS from languages where LANG=$langnum and SERIAL_NUM='$serialnum' ";
	$result=mysqli_query($con1, $sql);
	$img=mysqli_fetch_assoc($result);
	$lang=$img['WORDS']; 
	return $lang;
}

// 품종 이름으로 언어 사전 검색 
function select_str_word($con1, $langnum, $breed) {
	$sql="select SERIAL_NUM from languages where WORDS='$breed' ";
	$result=mysqli_query($con1, $sql);
	$img=mysqli_fetch_assoc($result);
	$serialnum=$img['SERIAL_NUM']; 
	$lang=selectwords($con1, $langnum, $serialnum); 
	return $lang;
}

// 품종 이름으로 언어 사전 검색 
function select_langnum($con1,$word) {
	$sql="select LANG from languages where WORDS='$word' ";
	$result=mysqli_query($con1, $sql);
	$img=mysqli_fetch_assoc($result);
	$langSN=$img['LANG']; 
	return $langSN;
}

$today = date("Y-m-d");

?>
<? 
	include('./connectdb.php'); 
	$connect=dbconect();
	$con1 = $connect;

?>
<? require "./config.php"; ?>

<!DOCTIME html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title> Review </title>


<!-- <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/json2/20110223/json2.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

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

</script>

<script>
	$(document).ready(
		function() {
			$( "#bdate" ).datepicker(
				{
        		dateFormat: 'yy-mm-dd',
        		showOn:'button',
        		buttonImage: './images/Icon_calendar.gif',  // 달력 icon 이미지
        		changeMonth: true,
        		changeYear: true,
        		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12']
				}
			);
		}
	)
	$(document).ready(
		function() {
			$( "#edate" ).datepicker(
				{
        		dateFormat: 'yy-mm-dd',
        		showOn:'button',
        		buttonImage: './images/Icon_calendar.gif',  // 달력 icon 이미지
        		changeMonth: true,
        		changeYear: true,
        		monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12']
				}
			);
		}
	)
</script>

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
			//document.getElementById("dvnum1").innerHTML=" pid="+pid+" flag="+flag;
			if(flag=='r'){
				window.location.href = './ReviewCheckDataModify.html'+'?pid='+pid;
			}
			else{
				location.reload();
			}

		} // END: if(httpxml.readyState==4) 
	} // END: function provengChanged()
	// 데이터베이스에서 자료 가지고 오기 위한 준비
	var url="./assessment.php";
	
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

function btn_submit(){
	var myForm = document.myForm;
	
	if(myForm.bdate.value == ""){
		alert("select beginning date  ");
		return;
	}else if(myForm.edate.value == ""){
		alert("select end date");
		return;
	}else if(myForm.bdate.value > myForm.edate.value){
		alert("Check the lookup date");
		return;
	}
			
	myForm.submit();
}

</script>
</head>

<body>
<form name="myForm" action="./revtable.html" method="POST">
	<input type=hidden name=st value=0>


<!--검색 start-->
<div class="container-fluid search_box01">
	<div class="form-inline col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
		
			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 pd_mg00">
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label search_label"><? echo selectwords($connect, $_SESSION['lang'], 'a0044'); ?>&nbsp;	<!--축주명--></div>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 search_in01"><input type="text" name="Owners_name" class="w90p" ></div>
			</div>

			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 pd_mg00">
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label search_label"><? echo selectwords($connect, $_SESSION['lang'], 'a0052'); ?>&nbsp;<!-- 진단일 --></div>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 search_in01">
					<input type="text" name="bdate" id="bdate" class="w80" readonly="readonly" onfocus="this.blur();" value="<?php echo $today; ?>"> ~	
					<input type="text" name="edate" id="edate" class="w80" readonly="readonly" onfocus="this.blur();" value="<?php echo $today; ?>">
				</div>
			</div>

			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 pd_mg00">
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label search_label"><? echo selectwords($connect, $_SESSION['lang'], 'a0053'); ?>&nbsp; <!-- 질병발생축종 --></div>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 search_in01">
					<select name=Disease_occurred_species class="w95p">
						<option value=''><? echo selectwords($connect, $_SESSION['lang'], 'a0053'); ?></option>
							<?Php
								require "config.php";// connection to database 
								$sql="select distinct anieng from animalstype";
								foreach ($dbo->query($sql) as $row) {
									$langanimalstype = select_str_word($connect, $_SESSION['lang'], $row[anieng]); 
									echo "<option value=$row[anieng]>$langanimalstype</option>";
								}
							?>
						</select>
				</div>
			</div>

			<div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 pd_mg00">
				<div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 control-label search_label"><? echo selectwords($connect, $_SESSION['lang'], 'a0056'); ?>&nbsp;<!--진단명--></div>
				<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 search_in01">
					<select name=diagdisease  class="w95p" >
						<option value=''> <? echo selectwords($connect, $_SESSION['lang'], 'a0086'); ?> 	</option>
							<?Php
								require "config.php";// connection to database 
								$sql="select distinct DisEng from animalspecydisease";
								foreach ($dbo->query($sql) as $row) {
									$langdisease = select_str_word($connect, $_SESSION['lang'], $row[DisEng]); 
									echo "<option value='$row[DisEng]'>$langdisease </option>";
								}
							?>
						</select>
				</div>
			</div>
		
		</div>

		<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 btn_mg01">
			<span class="btn_gtBlue w50"><a href='#' onclick="btn_submit()"><? echo selectwords($connect, $_SESSION['lang'], 'a0164'); ?></a></span><!--submit버튼-->	
		</div>

	</div>
</div>
<!--검색 end-->

</form>

<?php
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result = mysqli_query($con1,"SELECT * FROM disease where flagDelete=1");

mysqli_close($con1);
?>

</body>
</html>