<?
//ob_start(); // 출력 버퍼 조절 가능하게 함

include('connectdb.php'); 
$con1 = dbconect();


// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$select = "select * from regist";
$sql = mysqli_query($con1, $select);
$columns_total = mysqli_num_fields($sql);

//$output = ob_get_clean();// 앞서 버퍼에 들어 온 내용을 지우기

// Get The Field Name
while ($property = mysqli_fetch_field($sql)) {
	$heading = $property->name;
    $output .= '"'.$heading.'",';
}
$output.="\n";

// Get Records from the table
//$output1="";
while ($row = mysqli_fetch_array($sql)) {
	for ($i = 0; $i < $columns_total; $i++){
		$output .='"'.$row["$i"].'",';
	}
	$output .="\n";
}
mysqli_close($con1);
// Download the file
$filename="registdown.csv";
//ob_get_clean();
header("Content-type: text/csv; charset=utf-8");//charset=utf-8");
//header("Content-type: text/csv; charset=windows-1252");//charset=utf-8");
header("Content-Disposition: attachment; filename=$filename"); 
echo "\xEF\xBB\xBF";
echo $output;
die();
?>
