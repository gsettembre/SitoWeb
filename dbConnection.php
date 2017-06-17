<?php
	session_start();
	$db_username = 'b24_20165157';
	$db_password = 'passworderrata';
	$db_name = 'b24_20165157_museum_project';
	$hostname = 'sql303.byethost24.com:3306';
	
	mysql_select_db($db_name, mysql_pconnect($hostname, $db_username, $db_password)) or die ('Impossible connettersi al database'.mysql_error());
	
	function clear($var){
		return addslashes(htmlspecialchars(trim($var)));
	}