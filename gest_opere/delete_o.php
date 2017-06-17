<?php
	session_start();
	if(isset($_SESSION['username']))
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
$id = $_GET['id'];
 
// elimina la voce
$result = mysql_query("DELETE FROM opere WHERE ID='$id'")
or die(mysql_error());
 
// reindirizza alla pagina di visualizzazione
header('Location: view_o.php');
}
else
// se l'id non è impostato o non è valido reindirizza alla pagina di visualizzazione
{
header('Location: view_o.php');
}
 
?>
<?php
	}else {
		header('location: ../login.php');
	}
?>