
<?php

function dbcreate()
{

	//loacl server
	$con = mysqli_connect("DB ip","ezchart","ezchart","ezchart");

// Check connection
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql="CREATE TABLE Persons3(FirstName CHAR(30), LastName CHAR(30),Age INT, q1 INT)";

// Execute query
if (mysqli_query($con,$sql)) {
  echo "Table persons3 created successfully";
} else {
  echo "Error creating table: " . mysqli_error($con);
}


mysqli_close($con);

}
?>
