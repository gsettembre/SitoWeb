<?php
	session_start();
	if(isset($_SESSION['username']) === true)
	{	
?>
<?php
/*
DELETE.PHP
Cancella una voce specifica della tabella 'players'
*/
 
// connessione al database
include '../dbConnection.php';
 
// controlla se la variabile 'id' � impostata nell'URL, e controlla che sia valida
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// ottiene il valore id
$id = $_GET['id'];
 
// elimina la voce
$result = mysql_query("DELETE FROM struttura_museale WHERE ID='$id'") or trigger_error(mysql_error());
 
// reindirizza alla pagina di visualizzazione
header('Location: view_s.php');
}
else
// se l'id non � impostato o non � valido reindirizza alla pagina di visualizzazione
{
header('Location: view_s.php');
}
 
?>
<?php
	}else {
		header('location: ../login.php');
	}
?>