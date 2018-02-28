<?php
if($_SESSION['lang']==1){
	$tstr="changeLang('2')";
	$aaa='<input type="image" src="./images/korean.png" name="image" onClick="'.$tstr.'"  width="70" height="20"><br>';
	echo $aaa;
	
	$tstr2="changeLang('3')";
	$aa1='<input type="image" src="./images/english.png" name="image" onClick="'.$tstr2.'"  width="70" height="20">';
	echo $aa1;
		}
elseif($_SESSION['lang']==2){
		$tstr="changeLang('1')";
	$aaa='<input type="image" src="./images/mongolian.png" name="image" onClick="'.$tstr.'"  width="70" height="20"><br>';
	echo $aaa;
	
	$tstr2="changeLang('3')";
	$aa1='<input type="image" src="./images/english.png" name="image" onClick="'.$tstr2.'"  width="70" height="20">';
	echo $aa1;
		}
		
else{
	$tstr="changeLang('1')";
	$aaa='<input type="image" src="./images/mongolian.png" name="image" onClick="'.$tstr.'"  width="70" height="20"><br>';
	echo $aaa;
	
	$tstr2="changeLang('2')";
	$aa1='<input type="image" src="./images/korean.png" name="image" onClick="'.$tstr2.'"  width="70" height="20"><br>';
	echo $aa1;
		}		
?>