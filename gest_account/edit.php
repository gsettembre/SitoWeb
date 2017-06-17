<?php
	session_start();
	if(isset($_SESSION['username']))
	{	
?>

<?php
/*
EDIT.PHP
Consente all'utente di modificare una voce specifica nel database
*/
 
// crea il form di modifica record
// dal momento che questo modulo è utilizzato più volte in questo file, ho fatto una funzione facilmente riutilizzabile
function renderForm($id, $nome, $cognome, $username, $password, $ruolo, $error)
{
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
	<html>
		<head>
			<title>Modifica account</title>
			<link rel="icon" href="../images/favicon.ico" />
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<link rel="stylesheet" href="../assets/css/main.css" />
		</head>
		<body>
	<?php
		if($_SESSION['ruolo'] == 'Amministratore'){
			
		echo '<header id="header">
				<h1><strong><a href="../index.html">Museo Archeologico di Durazzo </a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="../gest_opere/view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="view.php">Gestione Account</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
					
				</nav>
			</header>';
			
		}else{
			echo '<header id="header">
				<h1><strong><a href="../index.html">Museo Archeologico di Durazzo </a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="../gest_opere/view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>';
			
		} ?>
		
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
			
		<?php
			
			// se ci sono errori, vengono visualizzati
			if ($error != '') {
			
				echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
			}?>
			
			<section id="main" class="wrapper">
				<div class="container">
					
					<!-- Form inserimento account-->
						<section>
							<h3>Modifica account</h3>
							<form action="" method="post">
								<input type="hidden" name="id" value="<?php echo $id;?>"/>
								<div class="row uniform 50%">
									<div class="6u 12u$(xsmall)">
										<input type="text" name="nome" value="<?php echo $nome; ?>" placeholder="Nome" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="cognome" value="<?php echo $cognome; ?>" placeholder="Cognome" />
									</div>
									<div class="6u 10u$(xsmall)">
										<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username (obbligatorio)" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password (obbligatorio)" />
									</div>	
									<div class="6u">
										<div class="select-wrapper">
											<select name="ruolo" id="ruolo" value="<?php echo $ruolo; ?>">
												<option value="1">Amministratore</option>
												<option value="2">Operatore</option>
											</select>
										</div>
									</div>
									<div class="12u$">
										<ul class="actions">
											<li><input type="submit" name="submit" value="Salva" class="special"/></li>
										</ul>
									</div>
								</div>
							</form>
						</section>
						
				</div>	

			</section> 
			
		</body>
	</html>
<?php
}
 
// connessione al database
include '../dbConnection.php';
 
// verifica se il modulo è stato inviato. Se lo è, inizia a elaborare il modulo e lo salva nel database
if (isset($_POST['submit'])){
	
	// verificare che il valore di 'id' sia un intero valido prima di ottenere i dati del modulo
	if (is_numeric($_POST['id'])){
		// ottenere i dati del modulo e verific che siano validi
		$id = $_POST['id'];
		$nome = mysql_real_escape_string(htmlspecialchars($_POST['nome']));
		$cognome = mysql_real_escape_string(htmlspecialchars($_POST['cognome']));
		$username = mysql_real_escape_string(htmlspecialchars($_POST['username']));
		$password = mysql_real_escape_string(htmlspecialchars($_POST['password']));
		$ruolo = mysql_real_escape_string(htmlspecialchars($_POST['ruolo']));
		 
		// controlla che i campi nome/cognome siano entrambi compilati
		if ($username == '' || $password == ''){
			// genera messaggio di errore
			$error = 'ERROR: Please fill in all required fields!';
			 
			// errore, visualizzo il modulo
			renderForm($id, $nome, $cognome, $username, $password, $ruolo, $error);
		} else{
			// salva i dati nel database
			mysql_query("UPDATE utenti SET Nome='$nome', Cognome='$cognome', Username='$username', Password='$password', Ruolo='$ruolo' WHERE ID='$id'") or die(mysql_error());
			 
			// una volta salvato, si viene reindirizzati alla pagina di visualizzazione
			header('Location: view.php');
		}
	}

	else
	{
		// Se l' 'id' non è valido, viene visualizzato un errore
		echo 'Error!';
	}
}else// se il modulo non è stato inviato, ottengo i dati dal db e visualizzare il modulo
{
		 
		// ottiene il valore 'id' dall'URL (se esiste), assicurandosi che sia valido (controlla che sia numerico/maggiore di 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
			
			// query db
			$id = $_GET['id'];
			$result = mysql_query("SELECT * FROM utenti WHERE ID=$id") or die(mysql_error());
			$row = mysql_fetch_array($result);
			 
			// verifica che l' 'id' corrisponda a una riga nel database
			if($row) {
			 
				// ottiene i dati dal db
				$nome = $row['Nome'];
				$cognome = $row['Cognome'];
				$username = $row['Username'];
				$password = $row['Password'];
				$ruolo = $row['Ruolo'];
				
				// visualizza il modulo
				renderForm($id, $nome, $cognome, $username, $password, $ruolo, '');
				
			} else { // se non corrisponde visualizza il risultato
				
				echo 'Nessun risultato!';
			}
		}
		else
		// se l' 'id' nell'URL non è valido, o se non vi è alcun valore di 'id', visualizza un errore
		{
			//stampa questo!
			echo 'Errore!';
		}
}
?>
<?php
	}else {
		header('location: ../login.php');
	}
?>