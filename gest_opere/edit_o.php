<?php
	session_start();
	if(isset($_SESSION['username']) === true)
	{	
?>

	<html>
		<head>
			<title>Modifica opera</title>
			<link rel="icon" href="../images/favicon.ico" />
			<meta charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1" />
			<link rel="stylesheet" href="../assets/css/main.css" />
		</head>
	<body>

<?php
// crea il form di modifica record
// dal momento che questo modulo è utilizzato più volte in questo file, ho fatto una funzione facilmente riutilizzabile
function renderForm($id, $nome, $autore, $corrente, $anno, $categoria, $dimensioni, $ubicazione, $descrizione, $error)
{
?>
	
	<?php
		if($_SESSION['ruolo'] === 'Amministratore'){
			
		$h_amm = <<<HTML
			<header id="header">
				<h1><strong><a href="../index.html">Museo Archeologico di Durazzo </a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="view_o.php">Gestione Opere</a></li>
						<li><a href="../gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="../gest_account/view.php">Gestione Account</a></li>
						<li><a href="../logout.php">Logout</a></li>
					</ul>
				</nav>
			</header>
HTML;
		echo $h_amm;
			
		}else{
			$h_op = <<<HTML
				<header id="header">
					<h1><strong><a href="../index.html">Museo Archeologico di Durazzo </a></strong></h1>
					<nav id="nav">
						<ul>
							<li><a href="view_o.php">Gestione Opere</a></li>
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
					
						<!-- Form inserimento opera -->
						<section>
							<h3>Modifica opera</h3>
							<form method="post" action="">
								<input type="hidden" name="id" value="<?php echo $id;?>"/>
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
											<select name="categoria" value="<?php echo $categoria;?>" >
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
										$query = mysql_query('SELECT Nome FROM struttura_museale') or trigger_error(mysql_error());
										echo '<div class="6u">';
											echo '<div class="select-wrapper">';
												echo '<select name="ubicazione" value="<?php echo $ubicazione;?>">';
												while($row = mysql_fetch_array($query))
												{ ?>
													<option value="<?php echo $row['Nome']?>"><?php echo $row['Nome'] ?></option>';
												<?php }
									?>
													</select>
												</div>
										</div>
									<div class="6u$ 12u$(xsmall)">
										<input type="text" name="dimensioni" value="<?php echo $dimensioni;?>" placeholder="Dimensioni" />
									</div>
									<div class="12u$">
										<input type="text" name="descrizione" value="<?php echo $descrizione;?>" placeholder="Descrizione opera" />
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
				</div>	
			</section> 
		</body>
	</html>
<?php
}
 
// connessione al database
include '../dbConnection.php';
 
// verifica se il modulo è stato inviato. Se lo è, inizia a elaborare il modulo e lo salva nel database
if (isset($_POST['submit']) === true){
	
	// verificare che il valore di 'id' sia un intero valido prima di ottenere i dati del modulo
	if (is_numeric($_POST['id'])){
		// ottenere i dati del modulo e verific che siano validi
		$id = $_POST['id'];
		$nome = mysql_real_escape_string(htmlspecialchars($_POST['nome']));
		$autore = mysql_real_escape_string(htmlspecialchars($_POST['autore']));
		$corrente = mysql_real_escape_string(htmlspecialchars($_POST['corrente']));
		$anno = mysql_real_escape_string(htmlspecialchars($_POST['anno']));
		$categoria = mysql_real_escape_string(htmlspecialchars($_POST['categoria']));
		$dimensioni = mysql_real_escape_string(htmlspecialchars($_POST['dimensioni']));
		$ubicazione = mysql_real_escape_string(htmlspecialchars($_POST['ubicazione']));
		$descrizione = mysql_real_escape_string(htmlspecialchars($_POST['descrizione']));
		 
		// controlla che i campi nome/cognome siano entrambi compilati
		if ($nome === '' || $autore === '' || $corrente === '' || $anno === '' || $categoria === '' || $dimensioni === '' || $ubicazione === '' || $descrizione === ''){
			// genera messaggio di errore
			$error = 'ERROR: Tutti i campi sono obbligatori!';
			 
			// errore, visualizzo il modulo
			renderForm($id, $nome, $autore, $corrente, $anno, $categoria, $dimensioni, $ubicazione, $descrizione, $error);
		} else{
			// salva i dati nel database
			mysql_query("UPDATE opere SET Nome='$nome', Autore='$autore', Corrente_artistica='$corrente', Anno_realizzazione='$anno', Categoria='$categoria', Dimensioni='$dimensioni', Ubicazione='$ubicazione', Descrizione='$descrizione' WHERE ID='$id'") or trigger_error(mysql_error());
			 
			// una volta salvato, si viene reindirizzati alla pagina di visualizzazione
			header('Location: view_o.php');
		}
	}

	else
	{
		// Se l' 'id' non è valido, viene visualizzato un errore
		echo 'Error, id non valido!';
	}
}else// se il modulo non è stato inviato, ottengo i dati dal db e visualizzare il modulo
{
		 
		// ottiene il valore 'id' dall'URL (se esiste), assicurandosi che sia valido (controlla che sia numerico/maggiore di 0)
		if (isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {
			
			// query db
			$id = $_GET['id'];
			$result = mysql_query("SELECT * FROM opere WHERE ID=$id") or trigger_error(mysql_error());
			$row = mysql_fetch_array($result);
			 
			// verifica che l' 'id' corrisponda a una riga nel database
			if($row) {
			 
				// ottiene i dati dal db
				$nome = $row['Nome'];
				$autore = $row['Autore'];
				$corrente = $row['Corrente_artistica'];
				$anno = $row['Anno_realizzazione'];
				$categoria = $row['Categoria'];
				$dimensioni = $row['Dimensioni'];
				$ubicazione = $row['Ubicazione'];
				$descrizione = $row['Descrizione'];
				
				// visualizza il modulo
				renderForm($id, $nome, $autore, $corrente, $anno, $categoria, $dimensioni, $ubicazione, $descrizione, $error);
				
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