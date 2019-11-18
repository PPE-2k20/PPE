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

  if(isset($_POST['numClient']) and isset($_POST['submitAffecter'])){
    $numClient = $_POST['numClient'];
    $_SESSION['numClient'] = $numClient;
    $ReqCodeRegAssis = "SELECT assistant.code_region FROM assistant, utilisateur WHERE  utilisateur.login = \"".$_SESSION['login']."\"";
    $ResultCodeRegAssis = mysqli_query($bdd,$ReqCodeRegAssis);
    $CodeRegAssis = $ResultCodeRegAssis->fetch_array(MYSQLI_ASSOC);
    $reqNomT = "SELECT technicien.nom, technicien.prenom FROM technicien, client, agence, assistant WHERE numero_client =\"".$numClient."\" and assistant.code_region =\"".$CodeRegAssis['code_region']."\"";
    $resultNomT = mysqli_query($bdd,$reqNomT);
  }

  $reqClientMax = "SELECT * FROM client";
  $resultClientMax=mysqli_query($bdd,$reqClientMax); 
  $sizeLD=mysqli_num_rows($resultClientMax);

 if(isset($_POST['submitAffecter']) and isset($_POST['matriculeT']) and isset($_POST['date_visite']) and isset($_POST['heure_visite']) and is_numeric($_SESSION['numClient'])){
      $date = $_POST['date_visite'];
      $heure = $_POST['heure_visite'];

      $matricule = "SELECT matricule FROM technicien WHERE nom = \"".$_POST['matriculeT']."\"";
      $resultMatriculeT = mysqli_query($bdd,$matricule);
      $mat = $resultMatriculeT->fetch_array(MYSQLI_ASSOC);

      $req = "INSERT INTO intervention (date_visite, heure_visite, matricule_technicien, numero_client,validation) VALUES (\"".$date."\",\"".$heure."\",\"".$mat['matricule']."\",\"".$_SESSION['numClient']."\",0)";
      $resultReq=mysqli_query($bdd,$req);
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

  	<u><h1 style="text-align: center;">Affecter une visite</h1></u>

    <form method="post" action="" autocomplete="off">
      <input type="number" id="numClient" name="numClient" style="width:150px;" placeholder="n°Client" min="1" max="<?php echo $sizeLD?>" required>
     
      <?php if(isset($_POST['submitAffecter']) and isset($_SESSION['numClient'])  ){ ?>
        <script>
            document.getElementById("numClient").setAttribute("value", <?php echo $_SESSION['numClient'] ?>);
            document.getElementById("numClient").setAttribute("readonly", <?php echo $_SESSION['numClient'] ?>);
        </script>
        <select name="matriculeT" required>
          <option value="" >--Choisir un technicien--</option>
            <?php while ($affiche = $resultNomT -> fetch_array(MYSQLI_ASSOC)) { ?>
              <option value="<?php echo $affiche['nom'];?>"><?php echo $affiche['nom'];?> <?php echo $affiche['prenom'];?></option>
         
            <?php 
              } 
            ?>

        </select>

        <input type="date" name="date_visite" required>       
        <input type="text" name="heure_visite" placeholder="Heure" required>

        <?php
          }
        ?>
        <script>
          function Open() {
            document.getElementById("retour").value = document.location.href = './affecterV_A.php';
          }
        </script>
      <button type="submit" class="btn btn-primary" name="submitAffecter">Valider</button>  
      <button type="submit" class="btn btn-primary" onclick="Open()" id="retour" name="submitRetour">Retour</button>  
    </form>

    <li><a href="logout.php">Déconnexion</a></li> 

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html> 