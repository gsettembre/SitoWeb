<?php
	session_start();
	if(isset($_SESSION['username']))	
	{	
?>

<html>
	<head>
		<title>Gestione strutture museali</title>
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
			
			
		<section id="main" class="wrapper">
		<div class="container">
			
		<?php
			 
			// connessione al database
			include('../dbConnection.php');
			 
			// ottiene i risultati dal database
			$result = mysql_query("SELECT * FROM struttura_museale") or die(mysql_error());
			 
			// visualizza i dati in tabella
			 
			echo "<section>";
							echo "<h4>Elenco strutture museali</h4>";
							echo "<div class='table-wrapper'>";
								echo "<table class='alt'>";
									echo "<thead>";
										echo "<tr>
											<th>ID</th>
											<th>Nome</th>
											<th>Indirizzo</th>
											<th>Descrizione</th>
											<th>Orari</th>
											<th>Responsabile</th>
										</tr>";
									echo "</thead>";
									echo "<tbody>";
									
			// loop tra i risultati della query del database, visualizzandoli in tabella
			while($row = mysql_fetch_array( $result )) {
				// emissione del contenuto di ogni riga in una tabella
				echo "<tr>";
				echo '<td>' .$row['ID'].'</td>';
				echo '<td>' . $row['Nome'] . '</td>';
				echo '<td>' . $row['Indirizzo'] . '</td>';
				echo '<td>' . $row['Descrizione'] . '</td>';
				echo '<td>' . $row['Orario_apertura'] . '</td>';
				echo '<td>' . $row['Responsabile'] . '</td>';
				echo '<td><a href="edit_s.php?id='.$row['ID'].'" class="button alt small">Modifica</a></td>';
				echo '<td><a href="delete_s.php?id='.$row['ID'].'" class="button special small">Elimina</a></td>';
				echo "</tr>";
			}
			 
			// chiude la tabella>
				echo '</tbody>
				<tfoot>
				</tfoot>
				</table>
				</div>
				</section>';
		?>
			<p><a href="new_s.php">Aggiungi una nuova struttura museale</a></p>
			</div>
			</section>
		
		
			<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="icons">
						<li><a href="https://www.facebook.com/Museo-archeologico-di-Durazzo-1349657348445064/" class="icon fa-facebook"></a></li>
						<li><a href="#" class="icon fa-twitter"></a></li>
						<li><a href="" class="icon fa-instagram"></a></li>
					</ul>
					<ul class="copyright">
						<li>&copy; Settembre Gaetano, Marchese Vito, Oranger Edoardo, Recchia Vito</li>
						<li>Design by: <a href="http://templated.co">TEMPLATED</a></li>
						<li>Images by: <a href="http://unsplash.com">Unsplash</a></li>
					</ul>
				</div>
			</footer>
			
		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
	</body>
</html>
<?php
	}else {
		header('location: ../login.php');
	}
?>