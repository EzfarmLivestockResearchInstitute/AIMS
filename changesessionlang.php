<? session_start(); ?>

<?
session_destroy();
session_start(); 
$_SESSION['lang']=2;
echo 'flag='.$_SESSION['lang'].'<br>';
header('Location: /hosting_index.html');
?>

<?
/*
if($flag =="Inputmore")  {
		header('Location: /SurveyInpuForm01.html');
}
else if ($_POST['flag']=="Savecorrected") {
    	header('Location: /SurveyInputDBInsertCor.html');
}
else{
    	header('Location: /index.html');
}
*/
?>

<html>
</html>
