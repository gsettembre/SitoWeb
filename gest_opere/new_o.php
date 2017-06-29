<?php
	session_start();
	if(isset($_SESSION['username']) === true)
	{	
?>
<html>
<head>
	<title>Inserimento opera</title>
	<link rel="icon" href="../images/favicon.ico" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="../assets/css/main.css" />
</head>
<body>

<?php
 
// crea il modulo di inserimento nuovi dati
// dal momento che questo modulo è utilizzato più volte in questo file, ho fatto una funzione facilmente riutilizzabile
function renderForm($id, $nome, $autore, $corrente, $anno, $categoria, $dimensioni, $ubicazione, $descrizione, $pronta, $error)
{
?>

<?php
		if($_SESSION['ruolo'] === 'Amministratore'){ ?>
			<header id="header">
				<h1><strong>Museo Archeologico di Durazzo</strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../gest_account/view.php">Gestione Account</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>					
		<?php } else { ?>
			<header id="header">
				<h1><strong>Museo Archeologico di Durazzo</strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>
		<?php } ?>
		
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
<?php
// se ci sono errori, vengono visualizzati
	$err = <<<HTML
		<div style="padding:4px; border:1px solid red; color:red;">$error</div>
HTML;
if ($error !== '')
	echo $err;
?>
		<section id="main" class="wrapper">
			<div class="container">
					<!-- Form inserimento opera -->
						<section>
							<h3>Inserimento opera</h3>
							<form method="post" action=""> 
								<div class="row uniform 50%">
									<div class="6u 12u$(xsmall)">
										<input type="text" name="nome" value="<?php echo $nome;?>" placeholder="Nome" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="autore" value="<?php echo $autore;?>" placeholder="Autore" />
									</div>
									<div class="6u 10u$(xsmall)">
										<input type="text" name="corrente" value="<?php echo $corrente;?>" placeholder="Corrente artistica" />
									</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="anno" value="<?php echo $anno;?>" placeholder="Anno realizzazione" />
									</div>	
									<div class="6u">
										<div class="select-wrapper">
											<select name="categoria" value="<?php echo $categoria;?>">
												<option value="0">- Categoria -</option>
												<option value="1">Dipinto</option>
												<option value="2">Disegno</option>
												<option value="3">Fotografia</option>
												<option value="4">Mosaico</option>
												<option value="5">Scultura</option>
												<option value="6">Vaso</option>
												<option value="7">Altro</option>
											</select>
										</div>
									</div>
									<?php
										$query = mysql_query('SELECT Nome FROM struttura_museale'); ?>
										<div class="6u">
											<div class="select-wrapper">
												<select name="ubicazione" value="<?php echo $ubicazione?>">
													<option value="0"> - Ubicazione - </option>
												<?php while($row = mysql_fetch_array($query))
												{ ?>
													<option value="<?php echo htmlspecialchars($row['Nome'])?>"><?php echo htmlspecialchars($row['Nome']) ?></option>
												 <?php }							
									?>
												</select>
											</div>
										</div>
									<div class="6u 12u$(xsmall)">
										<input type="text" name="dimensioni" value="<?php echo $dimensioni;?>" placeholder="Dimensioni" />
									</div>
									<div class="6u$">
										<div class="select-wrapper">
											<select name="pronta" value="<?php echo $pronta;?>">
												<option value="0">Pronta per la pubblicazione?</option>
												<option value="1">si</option>
												<option value="2">no</option>
											</select>
										</div>
									</div>
									<div class="12u$">
										<textarea name="descrizione" value="<?php echo $descrizione;?>" placeholder="Descrizione opera" rows="5"></textarea>
									</div>									
									<div class="12u$">
										<ul class="actions">
											<li><input name="submit" type="submit" value="Salva" class="special" /></li>
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
if (isset($_POST['submit']) === true)
{
// ottenere i dati del modulo e verifica che siano validi
	$nome = mysql_real_escape_string(htmlspecialchars($_POST['nome']));
	$autore = mysql_real_escape_string(htmlspecialchars($_POST['autore']));
	$corrente = mysql_real_escape_string(htmlspecialchars($_POST['corrente']));
	$anno = mysql_real_escape_string(htmlspecialchars($_POST['anno']));
	$categoria = mysql_real_escape_string(htmlspecialchars($_POST['categoria']));
	$dimensioni = mysql_real_escape_string(htmlspecialchars($_POST['dimensioni']));
	$ubicazione = mysql_real_escape_string(htmlspecialchars($_POST['ubicazione']));
	$descrizione = mysql_real_escape_string(htmlspecialchars($_POST['descrizione']));
	$pronta = mysql_real_escape_string(htmlspecialchars($_POST['pronta']));
 
// controlla che entrambi i campi vengono inseriti
if ($nome === ''){
	// genera messaggio di errore
	$error = "ERROR: Il campo Nome e' obbligatorio!";
	 
	// se uno dei due campi è vuoto, visualizzo di nuovo il modulo
	renderForm($id, $nome, $autore, $corrente, $anno, $categoria, $dimensioni, $ubicazione, $descrizione, $pronta, $error);
	
	} else{
		// salva i dati nel database
		mysql_query("INSERT INTO opere SET Nome='$nome', Autore='$autore', Corrente_artistica='$corrente', Anno_realizzazione='$anno', Categoria='$categoria', Dimensioni='$dimensioni', Ubicazione='$ubicazione', Descrizione='$descrizione', Pronta='$pronta'") or trigger_error(mysql_error());
	 
		// una volta salvato, si viene reindirizzati alla pagina di visualizzazione
		header('Location: view_o.php');
	}
}
else {
	// se il modulo non è stato inviato, visualizzare il modulo
	renderForm('','','','','','','','','','','');
}
?>

<?php
	}else {
		header('location: ../login.php');
	}
?>