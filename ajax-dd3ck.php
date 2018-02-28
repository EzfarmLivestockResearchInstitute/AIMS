<?Php
require "config.php";	// connection details

error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////
$proveng1=$_GET['proveng'];// 
$countyeng1 = $_GET['countyeng'];
$bageng1 = $_GET['bageng'];

$choice1 = $_GET['choice'];
$sessvar=$_GET['sessvar'];

$dispecies=$_GET['Disease_occurred_species'];

if(strlen($proveng1) > 0){
	if($sessvar == 1){
		$q_proveng="select distinct(countymong) from mongoladdress where proveng = '$proveng1'";	
	}
	elseif ($sessvar == 2){
		$q_proveng="select distinct(countykor) from mongoladdress where proveng = '$proveng1'";		
	}
	else{
		$q_proveng="select distinct(countyeng) from mongoladdress where proveng = '$proveng1'";	
	}
}

$sth = $dbo->prepare($q_proveng);
$sth->execute();
$countyeng = $sth->fetchAll(PDO::FETCH_COLUMN);


if(strlen($proveng1) > 0 and strlen($countyeng1) > 0){
	if($sessvar == 1){
		$q_countyeng="select distinct(bagmong) from mongoladdress where ( proveng = '$proveng1' and countymong='$countyeng1')";	
	}
	elseif ($sessvar == 2){
		$q_countyeng="select distinct(bagkor) from mongoladdress where ( proveng = '$proveng1' and countykor='$countyeng1')";		
	}
	else{
		$q_countyeng="select distinct(bageng) from mongoladdress where ( proveng = '$proveng1' and countyeng='$countyeng1')";	
	}
}

$sth = $dbo->prepare($q_countyeng);
$sth->execute();
$bageng = $sth->fetchAll(PDO::FETCH_COLUMN);





$choice = $choice1;

$teststr=$proveng1.$countyeng1;

$main = array('countyeng'=>$countyeng,'bageng'=>$bageng, 
              'value'=>array("sessvar"=>"$sessvar", "proveng1"=>"$proveng1","choice1"=>"$choice1","countyeng1"=>"$countyeng1","bageng1"=>"$bageng1"));
echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>