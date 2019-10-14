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
   <meta charset="utf-8">
	<title> Accueil Assistant </title>
  </head>

  <body>
  	<h2>Page accueil Assistantes</h2>
  	<a href="https://google.fr"/><center><button>Page 1</button></center>
  	<a href="https://google.fr"/><center><button>Page 2</button></center>
  	<a href="https://google.fr"/><center><button>Page 3</button></center>
  	<a href="https://google.fr"/><center><button>Page 4</button></center>
    <li><a href="logout.php">Déconnexion</a></li>
  </body>
</html> 