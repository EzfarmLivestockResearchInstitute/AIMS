<?Php
require "config.php";	// connection details

error_reporting(0); 	// With this no error reporting will be there
/////////////////////////////////////////////////////////////////////////////

$sessvar=$_GET['sessvar'];
$dispecies=$_GET['Disease_occurred_species'];

				

//������ ���� ����
$q_dispecies="select distinct(disease) from animalspecydisease where (specy = '$dispecies')";	
$q_langdispecies="select distinct(SERIAL_NUM) from languages where (WORDS = '$q_dispecies')";

$sth = $dbo->prepare($q_langdispecies);
$sth->execute();
$seldispe = $sth->fetchAll(PDO::FETCH_COLUMN);



//������ ���� ǰ��
$q_breed="select distinct(breed) from animalspecybreed where (specy = '$dispecies')";	
$sth = $dbo->prepare($q_breed);
$sth->execute();
$breed = $sth->fetchAll(PDO::FETCH_COLUMN);



$main = array('seldispe'=>$seldispe,  'breed'=>$breed, 'value'=>array("sessvar"=>"$sessvar"));
echo json_encode($main); 
////////////End of script /////////////////////////////////////////////////////////////////////////////////
?>