<?php 
session_start();
  if (!isset ($_SESSION['login'])) {
    header("location: index.php");
    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
  }elseif ($_SESSION['statut']=="Assistant") {
    header("location: accueil_A.php");
    //Si un assistant essaie d'acceder aux page technicien il est renvoyé vers la page assistant
  }

  $bdd = mysqli_connect("localhost","root","","ppe");

  $reqMatTechnicien = "SELECT technicien.matricule FROM technicien, utilisateur WHERE technicien.matricule = utilisateur.matricule and utilisateur.login =\"".$_SESSION['login']."\"";
  $resultMatTechnicien = mysqli_query($bdd,$reqMatTechnicien);
  $matT = $resultMatTechnicien ->fetch_array(MYSQLI_ASSOC);

  $req = "SELECT intervention.*, client.nomC, client.prenomC FROM intervention, client, technicien WHERE client.numero_client = intervention.numero_client and intervention.matricule_technicien=technicien.matricule and intervention.validation = 0 and technicien.matricule= \"".$matT['matricule']."\" ORDER BY numero_intervention asc";
  $result=mysqli_query($bdd,$req);


  if(isset($_POST['valider1']) || isset($_POST['valider2'])){
    if(isset($_POST['valider1'])){
          $_SESSION['total'] = $_POST['total'];
          $_SESSION['numMachine'] = $_POST['numMachine'];
          $_SESSION['intervention'] = $_POST['intervention'];
        }

    if(isset($_POST['valider2'])){
      $_SESSION['total'] = $_SESSION['total'] + $_POST['ajouter'];
    }
    
    if(isset($_POST['numSerie'.($_SESSION['total'])]) and isset($_POST['Commentaire'.($_SESSION['total'])]) and isset($_POST['nbHeure'.($_SESSION['total'])])){ 
        $numSerie = $_POST["numSerie".($_SESSION['total'])];
        $Commentaire = $_POST['Commentaire'.($_SESSION['total'])];
        $nbHeure = $_POST['nbHeure'.($_SESSION['total'])];
        $reqValidation = "UPDATE intervention SET Validation= 1 Where numero_intervention = ".$_SESSION['intervention'];
        $result=mysqli_query($bdd,$reqValidation);
        $reqControl = "INSERT INTO controler (numero_serie, numero_intervention, temps_passer, commentaire) VALUES (\"".$numSerie."\",\"".$_SESSION['intervention']."\",\"".$nbHeure."\",\"".$Commentaire."\")";
        $resultControl=mysqli_query($bdd,$reqControl);
        $result=mysqli_query($bdd,$req);
      } 
  }

  include_once 'db_connect.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Ca$hCa$h</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </head>

  <body>    
  	<form name="form1" method="post" action="">
    	<select multiple class="form-control col-6" size = 5 name="intervention" id="intervention" required>
        	<?php while ($affiche = $result -> fetch_array(MYSQLI_ASSOC)) {?>
        	    <option><?php echo $affiche['numero_intervention']." | ".$affiche['date_visite']." | ".$affiche['heure_visite']." | ".$affiche['nomC']." ".$affiche['prenomC']?></option>
       		 <?php } ?>
    	</select>
      <input type="number" class="form-control" name="numMachine" id="numMachine" placeholder="Nombre de machine" min="1" required>
      <input type="number" name="total" value="0" hidden>
      <button type="submit" class="btn btn-primary" name="valider1">Valider</button> 
    </form>

<?php
      if(isset($_POST['valider1']) || isset($_POST['valider2'])){

        if($_SESSION['total'] < $_SESSION['numMachine']){?>
          <form name="form2" method="post" action="">
            <div class="form-group">
              <input type="number" class="form-control" name="<?php echo "numSerie".$_SESSION['total'] ?>" placeholder="Numéro de série" min="1">
            </div>
            <div class="form-group">
              <textarea class="form-control" name="<?php echo "Commentaire".$_SESSION['total'] ?>" rows="3"></textarea>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" name="<?php echo "nbHeure".$_SESSION['total'] ?>" placeholder="Temps d'intervention">
            </div>
            <div class="modal-footer">
              <input type="number" name="ajouter" value="1" hidden>
              <button type="submit" name="valider2" class="btn btn-primary">Submit</button>
            </div>
            </form>
          <?php  
          }
        }    
      ?>

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
              <li>N°Client: <input type="text" name="prenom" placeholder="Prénom" value="<?php echo $affiche['numero_client']; ?>"></li>
              <li>Prénom: <input type="text" name="nom" placeholder="Nom" value="<?php echo $affiche['nomC']; ?>"></li>      
              <li>Nom: <input type="text" name="nom" placeholder="Prenom" value="<?php echo $affiche['prenomC']; ?>"></li>       
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
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Visualiser</button>
    </form>
   </body>
</html>