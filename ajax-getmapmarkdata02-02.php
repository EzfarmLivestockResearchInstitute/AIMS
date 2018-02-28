<?Php
require "config.php";	// connection details

error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////


$sessvar=$_GET['sessvar'];
$dispecies=$_GET['Disease_occurred_species'];// 질병 발생 축종, 소, 말 ...
$diagdisease=$_GET['diagdisease'];

$bdate01=$_GET['bdate']; // 시작 일
$bdate011="+1 day ".$bdate01;
$bdate = strtotime($bdate011);	

$edate01=$_GET['edate']; // 종료 일
$edate011="+1 day ".$edate01;
$edate = strtotime($edate011);

$lang = $_GET['lang'];


$q_deseaseplace = "SELECT ifnull(CONCAT('^',TITLE,',',CONTENTS,';',LIVESTOCK,'|',LA,'<', LO,'>', REG_DT), ' ') As lat FROM( SELECT TITLE ,CONTENTS ,LIVESTOCK ,LA ,LO ,REG_DT FROM board_answer WHERE 1=1 AND DELETE_SE = 1 ";


if($dispecies!=NULL){
	$q_deseaseplace=$q_deseaseplace." AND LIVESTOCK = '$dispecies' ";
}
//if($diagdisease!=NULL){
//	$q_deseaseplace=$q_deseaseplace." AND Diagnosis='$diagdisease'";
//}

$q_deseaseplace = $q_deseaseplace."AND REG_DT >= '$bdate01' AND REG_DT <= '$edate01' )ab";

//위도, 경도
$sth = $dbo->prepare($q_deseaseplace);
$sth->execute();
$lat_deg = $sth->fetchAll(PDO::FETCH_COLUMN);

$main = array('dplace'=>$lat_deg, "dispecies"=>"$dispecies",  'value'=>array("sessvar"=>"$sessvar", "bdate"=>"$bdate", "edate"=>"$edate", "edate01" =>"$edate01", "bdate01" =>"$bdate01", "bdate011" =>"$bdate011", "edate011" =>"$edate011"));

echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>