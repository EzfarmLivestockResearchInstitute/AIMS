<?Php
//require "config.php";	// connection details
error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////


$sessvar=$_GET['sessvar'];
$dispecies=$_GET['Disease_occurred_species'];// ���� �߻� ����, ��, �� ...
$diagdisease=$_GET['diagdisease'];
$bdate01=$_GET['bdate']; // ���� ��
$edate01=$_GET['edate']; // ���� ��

$main = array('diagdisease'=>$diagdisease, 'dispecies'=>$dispecies, 'county'=>$county, 'value'=>array("sessvar"=>"$sessvar", "edate01" =>"$edate01", "bdate01" =>"$bdate01"));

echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>