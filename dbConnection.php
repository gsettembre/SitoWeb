<?php
	session_start();
	$host = 'sql303.byethost24.com:3306'; 
	$user = 'b24_20165157'; 
	$pass = 'passworderrata';
	$db = 'b24_20165157_museum_project';

	$r = mysql_pconnect($host, $user, $pass);

	if ($r == true) {
		mysql_select_db($db,$r);
	} else {
		echo 'Non posso connettermi al server... Servizio temporaneamente non dispobibile!';
		trigger_error(mysql_error(), E_USER_ERROR);
	}
	
	function clear($var){
		return addslashes(htmlspecialchars(trim($var)));
	}