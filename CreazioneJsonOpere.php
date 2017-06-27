<?php
	$db_user = 'durresmuseum';
	$db_password = 'ilciucciovola';
	$db_name = 'my_durresmuseum';
	$host = 'localhost';
	
	$query = 'SELECT * FROM opere WHERE Pronta="si"';
	$conn = mysqli_connect($host, $db_user, $db_password, $db_name);
	
	$result = mysqli_query($conn,$query);
	$response = array();
	
	while($row = mysqli_fetch_array($result)){
		array_push($response,array("ID"=>$row[0], "Nome"=>$row[1], "Autore"=>$row[2], "Corrente_artistica"=>$row[3], "Anno_realizzazione"=>$row[4],
									"Categoria"=>$row[5], "Dimensioni"=>$row[6], "Ubicazione"=>$row[7], "Descrizione"=>$row[8], "Immagine"=>$row[9]));
	}
	
	echo json_encode(array("opere"=>$response));
	mysqli_close($conn);	
