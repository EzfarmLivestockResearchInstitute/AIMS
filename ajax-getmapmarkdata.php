<?Php
require "config.php";	// connection details
error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////
$sessvar=$_GET['sessvar'];
$dispecies=$_GET['Disease_occurred_species'];
$diagdisease=$_GET['diagdisease'];
$bdate01=$_GET['bdate']; 
$bdate011="+1 day ".$bdate01;
$bdate = strtotime($bdate011);	
$edate01=$_GET['edate']; 
$edate011="+1 day ".$edate01;
$edate = strtotime($edate011);
if (($bdate01!=NULL) and ($edate01!=NULL)) {
	if (($dispecies==NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Diagnostic_date <='$edate01' and Diagnosis='$diagdisease' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Diagnostic_date <='$edate01' and Disease_occurred_species = '$dispecies' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Diagnostic_date <='$edate01' and Disease_occurred_species = '$dispecies' and Diagnosis='$diagdisease' and flagDelete=1 )";
	}
	if(($dispecies==NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Diagnostic_date <='$edate01' and flagDelete=1)";
	}
}
if (($bdate01!=NULL) and ($edate01==NULL)) {
	if (($dispecies==NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Diagnosis='$diagdisease' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Disease_occurred_species = '$dispecies' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and Disease_occurred_species = '$dispecies' and Diagnosis='$diagdisease' and flagDelete=1 )";
	}
	if(($dispecies==NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date >='$bdate01' and flagDelete=1)";
	}
}
if (($bdate01==NULL) and ($edate01!=NULL)) {
	if (($dispecies==NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date <='$edate01' and Diagnosis='$diagdisease' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date <='$edate01' and Disease_occurred_species = '$dispecies' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date <='$edate01' and Disease_occurred_species = '$dispecies' and Diagnosis='$diagdisease' and flagDelete=1)";
	}
	if(($dispecies==NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnostic_date <='$edate01' and flagDelete=1)";
	}
}
if (($bdate01==NULL) and ($edate01==NULL)) {
	if (($dispecies==NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Diagnosis='$diagdisease' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where (Disease_occurred_species = '$dispecies' and flagDelete=1)";
	}
	if(($dispecies!=NULL) and ($diagdisease!=NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where ( Disease_occurred_species = '$dispecies' and Diagnosis='$diagdisease' and flagDelete=1 )";
	}
	if(($dispecies==NULL) and ($diagdisease==NULL)){
		$q_deseaseplace="SELECT  CONCAT('^',lat_deg,',',lat_min,';',lat_sec,':',long_deg,'<', long_min,'>', long_sec,'!') As lat FROM disease where flagDelete=1";
	}
}
$sth = $dbo->prepare($q_deseaseplace);
$sth->execute();
$lat_deg = $sth->fetchAll(PDO::FETCH_COLUMN);
$main = array('diagdisease'=>$diagdisease, 'dplace'=>$lat_deg, "dispecies"=>"$dispecies",  'value'=>array("sessvar"=>"$sessvar", "bdate"=>"$bdate", "edate"=>"$edate", "edate01" =>"$edate01", "bdate01" =>"$bdate01", "bdate011" =>"$bdate011", "edate011" =>"$edate011"));
echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>