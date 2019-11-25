<?php  
session_start();
  if (!isset ($_SESSION['login'])) {
    header("location: login.php");
    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
  }elseif ($_SESSION['statut']=="technicien") {
    header("location: accueil_A.php");
    //Si un assistant essaie d'acceder aux page technicien il est renvoyé vers la page assistant
  }

  $bdd = mysqli_connect("localhost","root","","ppe");
  $nomA = "SELECT nom , prenom FROM utilisateur, assistant Where assistant.matricule = utilisateur.matricule and login =\"".$_SESSION['login']."\"";
  $reqNom = mysqli_query($bdd,$nomA);
  $affiche = $reqNom->fetch_array(MYSQLI_ASSOC);

  //inclusion de la connexion à la base de données
  include_once 'db_connect.php';
  //echo (mysqli_error($connexion_a_la_bdd));

?>

<!DOCTYPE html>
<html>

 <head>
   <meta charset="utf-8">
	<title>Ca$hCa$h</title>
  </head>

  <body>
  	<h2>Page accueil Assistants</h2>
    <p><?php echo $affiche['nom']; ?> <?php echo $affiche['prenom']; ?></p>
  	<a href="recherche_A.php"/><center><button>Page de recherche</button></center></a>
  	<a href="affecterV_A.php"/><center><button>Affecter une visite</button></center></a>
  	<a href="consulteInter_A.php"/><center><button>Consulter les interventions</button></center></a>
  	<a href="https://google.fr"/><center><button>Page 4</button></center></a>
    <li><a href="logout.php">Déconnexion</a></li> 
  </body>
</html> 