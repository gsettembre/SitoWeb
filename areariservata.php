<!DOCTYPE HTML>
<?php
	include'dbConnection.php';
	if(isset($_SESSION['username']))
	{	
?>
<html>
	<head>
		<title>Area Riservata</title>
		<link rel="icon" href="images/favicon.ico" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<h1><strong><a href="index.html">Museo Archeologico di Durazzo </a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="gest_opere/view_o.php">Gestione Opere</a></li>
						<li><a href="gest_strutture/view_s.php">Gestione Strutture Museali</a></li>
						<li><a href="gest_account/view.php">Gestione Account</a></li>
						<li><a href="logout.php">Logout</a></li>
					</ul>
					
				</nav>
			</header>
		
		<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">					
					<section>
						<header>
							<p><?php echo 'Ciao ',$_SESSION['username']; ?></p><h3>Benvenuto nell'area riservata dedicata agli amministratori.</h3>

						</header>
						<p>All'interno di questa area è consentito l'accesso alle seguenti sezioni: </p>
							<div class="row">
								<div class="3u 12u$(xsmall)">

									<h4>Gestione Opere</h4>
									<ul>
										<li>Inserimento nuova opera</li>
										<li>Modifica dati opera esistente</li>
										<li>Cancellazione opera</li>
									</ul>
									
								</div>
								
								<div class="4u 12u(xsmall)">
									<h4>Gestione strutture museali</h4>
									<ul>
										<li>Inserimento nuova struttura museale</li>
										<li>Modifica dati struttura museale esistente </li>
										<li>Cancellazione struttura museale</li>
									</ul>
									

									
								</div>
								
								<div class="4u 12u(xsmall)">
									<h4>Gestione account</h4>
									<ul>
										<li>Inserimento nuovo account</li>
										<li>Modifica dati account esistente </li>
										<li>Cancellazione account</li>
									</ul>
									

									
								</div>
								
							</div>

							
					</section>
					
						
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
		header('location: login.php');
	}
?>