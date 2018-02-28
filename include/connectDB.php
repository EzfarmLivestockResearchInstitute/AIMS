<?
	$connect = mysqli_connect("server ip","user","password","database");

	if(!$connect) die("Fail to connect DB: ".mysql_error());//
?> 