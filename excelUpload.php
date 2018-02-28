<?php
//$str = "인코딩확인";
//$enc = mb_detect_encoding($str, array("UTF-8", "EUC-KR", "SJIS"));
//if ($str != "EUC-KR") {
//   $str = iconv($enc, "EUC-KR", $str);
//}

$target_dir = "/excel/";
$target_file = $target_dir.basename($_FILES["userfile"]["name"]);
$uploadOk = 1;

$ext = array_pop(explode(".", strtolower($target_file)));

if(!@ereg($ext, "xls")){ 
  echo "<script>alert('".iconv('UTF-8', 'EUC-KR', 'xls 파일만 가능합니다.')."'); location.href = '/excelUpload.html'; </script>";

} 

move_uploaded_file($_FILES['userfile']['tmp_name'] , $target_file);





require_once 'reader.php';

$data = new Spreadsheet_Excel_Reader();

$data->setOutputEncoding('EUC-KR');

$data->setRowColOffset(0);

$data->read($_FILES['userfile']['tmp_name']);

error_reporting(E_ALL ^ E_NOTICE);

$Owners_name = '';
$lat_deg = ''; 
$lat_min = ''; 
$lat_sec = '';
$long_deg = ''; 
$long_min = ''; 
$long_sec = '';

$province = '';
$county = '';
$bag = '';

$Diagnostic_date = '';
$New_additional_occurance = '';
$Disease_occurred_species = '';
$Diagnosis = ''; 


$bin = openssl_random_pseudo_bytes(20);
$footprint=bin2hex($bin);



	//if (!mysqli_query($con1,$sql1)) {
	//	die('Error: ' . mysqli_error($con1));
	//}

$add = iconv('UTF-8', 'EUC-KR', '추가');
for ($i = 1; $i <= $data->sheets[1]['numRows']; $i++) {
 if($i==1 || $i == $data->sheets[1]['numRows']){
  continue;
 }
	$Owners_name = $data->sheets[1]['cells'][$i][1];
	$lat_deg = $data->sheets[1]['cells'][$i][12]; 
	$lat_min = $data->sheets[1]['cells'][$i][13]; 
	$lat_sec = $data->sheets[1]['cells'][$i][14];
	$long_deg = $data->sheets[1]['cells'][$i][15]; 
	$long_min = $data->sheets[1]['cells'][$i][16]; 
	$long_sec = $data->sheets[1]['cells'][$i][17];
	
	$province = $data->sheets[1]['cells'][$i][2];
	$county = $data->sheets[1]['cells'][$i][3];
	$bag = $data->sheets[1]['cells'][$i][4];

	$Diagnostic_date = $data->sheets[1]['cells'][$i][8];
	$New_additional_occurance = $data->sheets[1]['cells'][$i][5];
	$Disease_occurred_species = $data->sheets[1]['cells'][$i][7];
	$Diagnosis = $data->sheets[1]['cells'][$i][10]; 

	$bin = openssl_random_pseudo_bytes(20);
	$footprint=bin2hex($bin);

	 $sql1="INSERT INTO disease (Owners_name,lat_deg,lat_min,lat_sec,long_deg,long_min,long_sec,province,county,bag, Diagnostic_date, New_additional_occurance, Disease_occurred_species, Diagnosis, footprint, deaths)
 VALUES ('$Owners_name','$lat_deg','$lat_min','$lat_sec','$long_deg','$long_min','$long_sec','$province','$county','$bag', concat('2015', substr('$Diagnostic_date',1, 2), substr('$Diagnostic_date',4, 2)),case when '$New_additional_occurance' = '".$add."' then 'Add' else 'New' END,'$Disease_occurred_species','$Diagnosis','$footprint', 0);";

 echo $sql1;
 echo "<br><br>";
}


?>
