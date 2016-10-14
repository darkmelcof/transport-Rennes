<?php
	include('configuration.php');
	// Connexion au serveur MySQL
	$conn = mysqli_connect($serveur, $login, $password, $database) or die('Erreur : '.mysql_error());
	$conn->set_charset('utf8');
?>