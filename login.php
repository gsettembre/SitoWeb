<?php
	//Fase 1: connessione DB
	include 'dbConnection.php';
	//Fase 2: controllo inserimento
	if(isset($_POST['login'])){
		$username = isset($_POST['username']) ? clear($_POST['username']) : false;
		$password = isset($_POST['password']) ? clear($_POST['password']) : false;
		
		//Funzioni per proteggersi contro l'iniezione SQL
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		
		$query = mysql_query("SELECT * FROM utenti WHERE Username='$username' AND Password='$password'");
		$rows = mysql_num_rows($query);
		if($rows == 1)
		{
			//$username = mysql_result(mysql_query("SELECT Username FROM utenti WHERE Username LIKE '$username'"), 0);
			$isAdmin = mysql_result(mysql_query("SELECT Ruolo FROM utenti WHERE Username='$username' AND Password='$password'"),0);
			$_SESSION['username'] = $username;
			$_SESSION['ruolo'] = $isAdmin;
			if($isAdmin == 'Amministratore'){
				header('Location: areariservata.php'); 
			}else{
				header('Location: areariservataop.php');
			}
		}
		else
		{
				echo("<SCRIPT LANGUAGE = 'JavaScript'>
						window.alert('Credenziali non valide!')
						window.location.href = 'login.php';
						</SCRIPT>");
		}
	}else{
?>
<html>
	<head>
		<title>Login</title>
		<link rel="icon" href="images/favicon.ico" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" href="assets/css/login.css" />
		
	</head>
	<body>

			<header id="header">
				<h1><strong><a href="index.html">Museo Archeologico di Durazzo</a></strong></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="lenostreopere.html">Le nostre opere</a></li>
					</ul>
				</nav>
			</header>

			<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>

				<div class="login">
					<div class="login-screen">
			<div class="app-title">
				<h1>Login</h1>
			</div>

			<div class="login-form">
				<div class="control-group">
					<form name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
						<input type="text" class="login-field" value="" placeholder="Username"  name="username">
						<label class="login-field-icon fui-user" for="login-name"></label>
				</div>

				<div class="control-group">
					<input type="password" class="login-field" value="" placeholder="Password"  name="password">
					<label class="login-field-icon fui-lock" for="login-pass"></label>
				</div>
				<input name="login" type="submit" value="Login" class="button special"/>
			    </form>
					
			</div>
			

			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>
<?php
	}
?>