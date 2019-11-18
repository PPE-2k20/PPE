<?php  
session_start();
  if (!isset ($_SESSION['login'])) {
    header("location: index.php");
    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
  }elseif ($_SESSION['statut']=="assistant") {
    header("location: accueil_T.php");
    //Si un assistant essaie d'acceder aux page technicien il est renvoyé vers la page assistant
  }

  $bdd = mysqli_connect("localhost","root","","ppe");
  $nomA = "SELECT nom , prenom FROM utilisateur, technicien Where technicien.matricule = utilisateur.matricule and login =\"".$_SESSION['login']."\"";
  $reqNom = mysqli_query($bdd,$nomA);
  $affiche = $reqNom->fetch_array(MYSQLI_ASSOC);
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
	<p><?php echo $affiche['nom']; ?> <?php echo $affiche['prenom'];?></p>	
	<br>
	<center><a href="InterV_T.php"><input type="button" name="Intervention Validation" value="Intervention / Validation" ></a></center>
	<li><a href="logout.php">Déconnexion</a></li>
</body>
</html>