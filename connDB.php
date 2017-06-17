<?php

	//10.0.2.2
	$host = "sql303.byethost24.com:3306";
	$user = "b24_20165157";
	$password = "passworderrata";
	$db_name = "b24_20165157_museum_project";
	$id = 1;
	$query = "SELECT * FROM utenti WHERE ID='$id'";
	
	$con = mysqli_connect($host, $user, $password, $db_name);
	
	$result = mysqli_query($con, $query);

	$response = array();


	


	while($row = mysqli_fetch_array($result)){
		array_push($response, array("ID"=>$row[0], "Name"=>$row[1], "Cognome"=>$row[2], "Username"=>$row[3], "Password"=>$row[4]));
	}

	echo json_encode(array("server response"=>$response));
	
	mysqli_close($con);

?>