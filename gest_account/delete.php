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
 
// controlla se la variabile 'id' è impostata nell'URL, e controlla che sia valida
if (isset($_GET['id']) && is_numeric($_GET['id']))
{
// ottiene il valore id
$id = mysql_real_escape_string($_GET['id']); 
 
// elimina la voce
$query = sprintf("DELETE FROM utenti WHERE ID = '%s'", mysql_real_escape_string($id));
$result = mysql_query($query) or trigger_error(mysql_error());
 
// reindirizza alla pagina di visualizzazione
header('Location: view.php');
}
else
// se l'id non è impostato o non è valido reindirizza alla pagina di visualizzazione
{
header('Location: view.php');
}
 
?>
<?php
	}else {
		header('location: ../login.php');
	}
?>