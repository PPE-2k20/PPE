<?php  

session_start();

if (!isset ($_SESSION['login'])) {
    header("location: index.php");
}else{
    $login=$_SESSION['login'];
    $satut=$_SESSION['statut'];
}


//inclusion de la connexion à la base de données
include_once 'db_connect.php';


//echo (mysqli_error($connexion_a_la_bdd));


?>
<!DOCTYPE html>
<html>
<head>
	<title>Accueil Technicien</title>
	<meta charset="utf-8">
</head>
<body>
	<u><h1 style="text-align: center;">Accueil technicien</h1></u>	
	<br>
	<center><a href="https://www.google.fr" target="_blank"><input type="button" name="Intervention Validation" value="Intervention / Validation" ></a></center>
	
	<li><a href="logout.php">Déconnexion</a></li>
</body>
</html>