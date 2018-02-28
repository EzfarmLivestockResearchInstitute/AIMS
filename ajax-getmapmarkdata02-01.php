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


$q_deseaseplace = "SELECT  ifnull(CONCAT('^',lat_deg,',',lat_min,';',lat_sec,'|',long_deg,'<', long_min,'>', long_sec,'!',Diagnosis,'@',Diagnostic_date,'%',Disease_occurred_species,'&',ifnull(Cases, ' '),'(',province,')',county,'[',bag,']'), ' ') As lat FROM (SELECT  lat_deg, lat_min , lat_sec	, long_deg	, long_min	, long_sec	, Diagnostic_date	, (select words from languages where serial_num = a.serial_num and lang= '$lang') as Diagnosis	, (select words from languages where serial_num = b.serial_num and lang= '$lang') as Disease_occurred_species , ifnull(Cases, ' ') as Cases , province, county, bag FROM disease aa left outer join (select serial_num, words from languages ) a on a.words = aa.Diagnosis left outer join (select serial_num, words from languages ) b on b.words = aa.Disease_occurred_species where Diagnostic_date >= '$bdate01' and Diagnostic_date <= '$edate01' and flagDelete=1";


if($dispecies!=NULL){
	$q_deseaseplace=$q_deseaseplace." AND Disease_occurred_species = '$dispecies'";
}
if($diagdisease!=NULL){
	$q_deseaseplace=$q_deseaseplace." AND Diagnosis='$diagdisease'";
}

$q_deseaseplace = $q_deseaseplace.") ab";

//echo $q_deseaseplace;
//위도, 경도
$sth = $dbo->prepare($q_deseaseplace);
$sth->execute();
$lat_deg = $sth->fetchAll(PDO::FETCH_COLUMN);

$main = array('diagdisease'=>$diagdisease, 'dplace'=>$lat_deg, "dispecies"=>"$dispecies",  'value'=>array("sessvar"=>"$sessvar", "bdate"=>"$bdate", "edate"=>"$edate", "edate01" =>"$edate01", "bdate01" =>"$bdate01", "bdate011" =>"$bdate011", "edate011" =>"$edate011"));

echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>