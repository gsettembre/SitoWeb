<?php
	session_start();
	if(isset($_SESSION['username']))
	{	
?>

<?php
 
// crea il modulo di inserimento nuovi dati
// dal momento che questo modulo è utilizzato più volte in questo file, ho fatto una funzione facilmente riutilizzabile
function renderForm($id, $nome, $indirizzo, $descrizione, $orario, $responsabile, $error)
{
?>
<html>
<head>
	<title>Inserimento struttura museale</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>

<?php
	echo '<body>';
		if($_SESSION['ruolo'] == 'Amministratore'){
			
		echo '<header id="header">
				<h1><strong><a href="../index.html">Museo Archeologico di Durazzo </a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="../gest_opere/view_o.php">Gestione Opere</a></li>
						<li><a href="view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../gest_account/view.php">Gestione Account</a></li>
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
						<li><a href="view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>';
			
		} ?>
		
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
<?php

// se ci sono errori vengono visualizzati
if ($error != '')
{
echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
}
?>
 
<section id="main" class="wrapper">
				<div class="container">
					
						<!-- Form inserimento struttura museale-->
						<section>
							<h3>Inserimento Struttura museale</h3>
							<form method="post" action="">
								<div class="row uniform 50%">
									<div class="6u 12u$(xsmall)">
										<input type="text" name="nome" value="<?php echo $nome; ?>" placeholder="Nome" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="indirizzo" value="<?php echo $indirizzo; ?>" placeholder="Indirizzo" />
									</div>
									<div class="6u 10u$(xsmall)">
										<input type="text" name="orario" value="<?php echo $orario; ?>" placeholder="Orari di apertura" />
									</div>
									<div class="6u 10u$(xsmall)">
										<input type="text" name="responsabile" value="<?php echo $responsabile; ?>" placeholder="Responsabile" />
									</div>
									<div class="12u$">
										<textarea type="text" height="50" name="descrizione" value="<?php echo $descrizione; ?>" placeholder="Descrizione struttura museale" rows="5"></textarea>
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
include('../dbConnection.php');
 
// verifica se il modulo è stato inviato. Se lo è, inizia a elaborare il modulo e lo salva nel database
if (isset($_POST['submit']))
{
// ottenere i dati del modulo e verifica che siano validi
	$nome = mysql_real_escape_string(htmlspecialchars($_POST['nome']));
	$indirizzo = mysql_real_escape_string(htmlspecialchars($_POST['indirizzo']));
	$orario = mysql_real_escape_string(htmlspecialchars($_POST['orario']));
	$responsabile = mysql_real_escape_string(htmlspecialchars($_POST['responsabile']));
	$descrizione = mysql_real_escape_string(htmlspecialchars($_POST['descrizione']));
 
// controlla che entrambi i campi vengono inseriti
if ($nome == '' || $indirizzo == '' || $orario == '' || $responsabile == '' || descrizione == ''){
	// genera messaggio di errore
	$error = 'ERROR: Tutti i campi sono obbligatori!';
	 
	// se uno dei due campi è vuoto, visualizzo di nuovo il modulo
	renderForm($id, $nome, $indirizzo, $descrizione, $orario, $responsabile, $error);
	
	} else{
		// salva i dati nel database
		mysql_query("INSERT struttura_museale SET Nome='$nome', Indirizzo='$indirizzo', Orario_apertura='$orario', Responsabile='$responsabile', Descrizione='$descrizione'") or die(mysql_error());
	 
		// una volta salvato, si viene reindirizzati alla pagina di visualizzazione
		header("Location: view_s.php");
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