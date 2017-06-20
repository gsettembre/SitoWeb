<?php
	session_start();
	$host = 'localhost'; 
	$user = 'durresmuseum'; 
	$pass = 'ilciucciovola';
	$db = 'my_durresmuseum';

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