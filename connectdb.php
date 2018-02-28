<?php

function dbconect() {
	$connect =mysqli_connect("DB ip","user","password","target database");

	if(!$connect)
		die("DB 접속 실패: " .mysql_error());

	return $connect;
}
?>
