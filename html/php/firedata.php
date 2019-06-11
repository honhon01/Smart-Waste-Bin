<?php
	$servername = "localhost";
	$username = "wastebin";
	$password = "wastebin";
	$databasename = "waste_bin";
	// Create connection
	$conn = new mysqli($servername, $username, $password, $databasename);			

	$dbdata = array();
	$sql = "SELECT * FROM fireData ORDER BY time DESC LIMIT 1";
	$result = $conn->query($sql);
	
	while($ligne = $result->fetch_assoc())
		{
		$dbdata[]=$ligne;
		}
	echo json_encode($dbdata);
	
?>