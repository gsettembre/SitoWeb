<?php
	session_start();
	if(isset($_SESSION['username']) === true)
	{	
?>
<?php
 
// crea il modulo di inserimento nuovi dati
// dal momento che questo modulo è utilizzato più volte in questo file, ho fatto una funzione facilmente riutilizzabile
function renderForm($id, $nome, $cognome, $username, $password, $ruolo, $error)
{
?>
<html>
<head>
	<title>Inserimento account</title>
	<link rel="icon" href="../images/favicon.ico" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body>
<?php
		if($_SESSION['ruolo'] == 'Amministratore'){
		$h_amm = <<<HTML
			<header id="header">
				<h1><strong>Museo Archeologico di Durazzo</strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="../gest_opere/view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="view.php">Gestione Account</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>
HTML;
		echo $h_amm;			
		}else{
			$h_op = <<<	HTML
				<header id="header">
					<h1><strong>Museo Archeologico di Durazzo</strong></h1>
					<nav id="nav">
						<ul>
							<li><a href="../gest_opere/view_o.php">Gestione Opere</a></li>
							<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
							<li><a href="../logout.php">Logout</a></li>
						</ul>
					</nav>
				</header>
HTML;
		echo $h_op;			
		} ?>
		
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
<?php
// se ci sono errori, vengono visualizzati
	$err = <<<HTML
		<div style="padding:4px; border:1px solid red; color:red;">$error</div>
HTML;
if ($error != '')
	echo $err;
?> 
<section id="main" class="wrapper">
				<div class="container">
					<!-- Form inserimento account-->
						<section>
							<h3>Inserimento Account</h3>
							<form method="post" action=""> 
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
											<select name="ruolo" id="ruolo">
												<option value="0">- Ruolo -</option>
												<option value="1">Amministratore</option>
												<option value="2">Operatore</option>
											</select>
										</div>
									</div>
									<div class="12u$">
										<ul class="actions">
											<li><input name="submit" type="submit" value="Salva" class="special"/></li>
										</ul>
									</div>
								</div>
							</form>
						</section>
				</div>	
			</section>			
			
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
</body>
</html>
<?php
}
 
// connessione al database
include '../dbConnection.php';
 
// verifica se il modulo è stato inviato. Se lo è, inizia a elaborare il modulo e lo salva nel database
if (isset($_POST['submit']))
{
// ottenere i dati del modulo e verific che siano validi
	$nome = mysql_real_escape_string(htmlspecialchars($_POST['nome']));
	$cognome = mysql_real_escape_string(htmlspecialchars($_POST['cognome']));
	$username = mysql_real_escape_string(htmlspecialchars($_POST['username']));
	$password = mysql_real_escape_string(htmlspecialchars($_POST['password']));
	$ruolo = mysql_real_escape_string(htmlspecialchars($_POST['ruolo']));
 
// controlla che entrambi i campi vengono inseriti
if ($username == '' || $password == '' || $nome == '' || $cognome == '' || $ruolo == ''){
	// genera messaggio di errore
	$error = 'ERROR: Tutti i campi sono obbligatori!';
	 
	// se uno dei due campi è vuoto, visualizzo di nuovo il modulo
	renderForm($id, $nome, $cognome, $username, $password, $ruolo, $error);
	
	} else{
		// salva i dati nel database
		mysql_query("INSERT utenti SET Nome='$nome', Cognome='$cognome', Username='$username', Password='$password', Ruolo='$ruolo'") or trigger_error(mysql_error());
	 
		// una volta salvato, si viene reindirizzati alla pagina di visualizzazione
		header('Location: view.php');
	}
}
else {
	// se il modulo non è stato inviato, visualizzare il modulo
	renderForm('','','','','','','');
}
?>

<?php
	}else {
		header('location: ../login.php');
	}
?>