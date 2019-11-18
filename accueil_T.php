<?php  
	session_start();

	if (!isset ($_SESSION['login'])) {
	    header("location: index.php");
	    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
	}elseif ($_SESSION['statut']=="Assistant") {
	  header("location: accueil_A.php");
	    //Si un Assistant essaie d'acceder aux page assistant il est renvoyé vers la page assistant
	}

	$c = new PDO('mysql:host=localhost;dbname=ppe','root');
	$recherche = $_SESSION['login'];
    $reqMatricule = $c->prepare('SELECT nom , prenom  FROM utilisateur, technicien Where login = ?');
    $reqMatricule->execute(array($recherche));
    $affiche = $reqMatricule->fetch();
//inclusion de la connexion à la base de données
include_once 'db_connect.php';
//echo (mysqli_error($connexion_a_la_bdd));
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ca$hCa$h</title>
	<meta charset="utf-8">
</head>
<body>
	<u><h1 style="text-align: center;">Accueil technicien</h1></u>
	<p><?php echo $affiche['nom']; ?> <?php echo $affiche['prenom']; ?></p>	
	<br>
	<center><a href="InterV_T.php"><input type="button" name="Intervention Validation" value="Intervention / Validation" ></a></center>
	<li><a href="logout.php">Déconnexion</a></li>
</body>
</html>