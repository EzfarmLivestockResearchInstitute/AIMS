<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>

<?php 
$message=$_POST['contents'];
$sendername=$_POST['from_name'];
$subj=$_POST['subject'];
$sendermail =$_POST['mail_from'];

$mail_from = "webmaster@aims.or.kr"; // 보내는 사람메일주소, cafe24.com에 호스팅 서비스를 받고 있는 도메인에 등록된 email 주소 
$from_name = '=?UTF-8?B?'.base64_encode($sendername).'?='; // 보내는사람 이름 
$mail_to = "webmaster@aims.or.kr"; // 받는사람 메일주소 

$Headers = "MIME-Version: 1.0\r\n";
$Headers .= 'from: '.$from_name.' aaa '.$mail_from."\r\n";// from 과 : 은 붙여주세요 => from: 
//$Headers .= "Content-Type: text/html;"; 
$Headers .= "Content-Type: text/plain; charset=utf-8\r\n"; // headers 에서 charset utf-8을 지정 

$subject = '=?UTF-8?B?'.base64_encode($subj).'?='; 
$contents01 =
"편지 보내는 사람 이름:".$sendername 
."편지 보내는 사람의 메일 주소: ".$sendermail
."<br>"
."<br>"
."<br>"
.$message
."<br>"
; 

if ( !$sendermail ) {
	echo "<script>
	window.alert('보내는 사람 메일주소를 꼭 써주세요!')
	history.go(-1)
	</script>";
	exit(1);  
	}

elseif ( !$sendername ) {
	echo "<script>
	window.alert('보내는 사람 이름을 꼭 써주세요!')
	history.go(-1)
	</script>";
	exit(1);  
	}

elseif (!$subj){
	echo "<script>
	window.alert('제목을 입력해주세요!')
	history.go(-1)
	</script>";
	exit(1);  
	}
elseif ( !$message ) {
	echo "<script>
	window.alert('내용을 입력해주세요!')
	history.go(-1)
	</script>";
	exit(1);  
	}
else {

	echo "<script>
	window.alert('관리자에게 편지가 성공적으로 발송되었습니다.')
	location.replace('../dolist.html')
	</script>";

	}
mail($mail_to,$subject,$contents01,$Headers); 

$mes="Mail is sent to the administrator.";
echo $mes;

?> 

	
</body>	
</html>