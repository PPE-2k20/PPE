<?php
  session_start();
  if (!isset ($_SESSION['login'])) {
    header("location: index.php");
    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
  }elseif ($_SESSION['statut']=="Technicien") {
    header("location: accueil_T.php");
    //Si un technicien essaie d'acceder aux page assistant il est renvoyé vers la page technicien
  }

  $bdd = mysqli_connect("localhost","root","","ppe");
  
  if (isset($_POST['submitRecherche'])) {  
    $numero_client = $_POST['recherche'];
    $_SESSION['numero_client'] = $numero_client;
    $req = "SELECT * FROM client WHERE numero_client = ".$_SESSION['numero_client'];
    $resultClient=mysqli_query($bdd,$req);
    //réaffiche la liste lorsqu'on ne met pas de N°Client
    if(!($_POST['recherche'])){
      $resultClient= null;   
    }
  }

  $reqClientMax = "SELECT * FROM client";
  $resultClientMax=mysqli_query($bdd,$reqClientMax); 
  $sizeLD=mysqli_num_rows($resultClientMax);

  if (isset($_POST['submitModal'])){
    $req = "UPDATE `client` SET numero_client=\"".$_POST['numClient']."\", prenomC =\"".$_POST['prenom']."\" , nomC =\"".$_POST['nom']."\" ,raison_sociale =\"".$_POST['raison_sociale']."\" , siren =\"".$_POST['siren']."\", code_APE =\"".$_POST['code_ape']."\" , adresse =\"".$_POST['adresse']."\" , telephone =\"".$_POST['telephone']."\" , fax =\"".$_POST['fax']."\" , email =\"".$_POST['email']."\" , duree_deplacement =\"".$_POST['duree_deplacement']."\" ,distance_km =\"".$_POST['distance_km']."\" ,`numero_agence`= \"".$_POST['numero_agence']."\" WHERE numero_client =\"".$_SESSION['numero_client']."\"";
    $result=mysqli_query($bdd,$req);   
  }
  
  //inclusion de la connexion à la base de données
  include_once 'db_connect.php';
  //echo (mysqli_error($connexion_a_la_bdd));
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Ca$hCa$h</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <u><h1 style="text-align: center;">Rechercher un Client</h1></u>

    <form method="post" action="" autocomplete="off">
      <input type="number" name="recherche" placeholder="n°Client"  min="1" max="<?php echo $sizeLD ?>" style="width:150px;" required>
      <button type="submit" class="btn btn-primary"  name="submitRecherche" class="">Valider</button>   
    </form>

  <br/>
  
  <div>
      <?php

      $reqClientMax = "SELECT * FROM client";
      $resultClientMax=mysqli_query($bdd,$reqClientMax); 
      $sizeLD=mysqli_num_rows($resultClientMax);

      if (isset($_POST['submitRecherche']) && ($_POST['recherche'])){
              $affiche = $resultClient->fetch_array(MYSQLI_ASSOC);
      ?>

      <p>N°Client: <?php echo $affiche['numero_client']; ?></p>
      <p>Prénom: <?php echo $affiche['prenomC']; ?></p>
      <p>Nom: <?php echo $affiche['nomC']; ?></p>
      <p>Raison sociale: <?php echo $affiche['raison_sociale']; ?> </p>
      <p>Siren: <?php echo $affiche['siren']; ?></p>
      <p>Code APE: <?php echo $affiche['code_APE']; ?></p>
      <p>Adresse: <?php echo $affiche['adresse']; ?></p>
      <p>Téléphone: <?php echo $affiche['telephone']; ?></p>
      <p>Fax: <?php echo $affiche['fax']; ?></p>
      <p>Email: <?php echo $affiche['email']; ?></p>
      <p>Durée de déplacement: <?php echo $affiche['duree_deplacement']; ?></p>
      <p>Distance km:<?php echo $affiche['distance_km']; ?></p>
      <p>N°Agence: <?php echo $affiche['numero_agence']; ?></p>
      <?php 
       }
      ?>
  </div>
  
  <form method="post" action =""> 
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier un client</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body" >

          <lo>
            <li>N°Client: <input type="text" name="numClient" placeholder="N°Client" value="<?php echo $affiche['numero_client']; ?>"></li>
            <li>Prénom: <input type="text" name="prenom" placeholder="Prenom" value="<?php echo $affiche['prenomC']; ?>"></li>      
            <li>Nom: <input type="text" name="nom" placeholder="Nom" value="<?php echo $affiche['nomC']; ?>"></li>       
            <li>Raison sociale: <input type="text" name="raison_sociale" placeholder="Raison sociale" value="<?php echo $affiche['raison_sociale']; ?>"></li>
            <li>Siren: <input type="text" name="siren" placeholder="Siren" value="<?php echo $affiche['siren']; ?>"></li>
            <li>Code APE: <input type="text" name="code_ape" placeholder="Code APE" value="<?php echo $affiche['code_APE']; ?>"></li>
            <li>Adresse: <input type="text" name="adresse" placeholder="Adresse" value="<?php echo $affiche['adresse']; ?>"></li>
            <li>Téléphone: <input type="text" name="telephone" placeholder="Téléphone" value="<?php echo $affiche['telephone']; ?>"></li>
            <li>Fax: <input type="text" name="fax" placeholder="Fax" value="<?php echo $affiche['fax']; ?>"></li>
            <li>Email: <input type="text" name="email" placeholder="Email" value="<?php echo $affiche['email']; ?>"></li>
            <li>Durée de déplacement: <input type="text" name="duree_deplacement" placeholder="Durée déplacement" value="<?php echo $affiche['duree_deplacement']; ?>"></li>
            <li>Distance km: <input type="text" name="distance_km" placeholder="Distance kilométrique" value="<?php echo $affiche['distance_km']; ?>"></li>
            <li>N°Agence: <input type="text" name="numero_agence" placeholder="n°Agence" value="<?php echo $affiche['numero_agence']; ?>"></li>
          </lo>         
             
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary" name="submitModal">Valider</button>
            </div>
        </div>
      </div>
    </div>  
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Modifier</button>
  </form>

  <li><a href="logout.php">Déconnexion</a></li>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>