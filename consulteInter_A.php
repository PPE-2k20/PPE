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

  $ReqCodeRegAssis = "SELECT assistant.code_region FROM assistant, utilisateur WHERE assistant.matricule = utilisateur.matricule and utilisateur.login = \"".$_SESSION['login']."\"";
  $ResultCodeRegAssis = mysqli_query($bdd,$ReqCodeRegAssis);
  $CodeRegAssis = $ResultCodeRegAssis->fetch_array(MYSQLI_ASSOC);

  $reqTechnicien= "SELECT technicien.nom, technicien.prenom FROM technicien, agence, assistant WHERE assistant.code_region = agence.code_region and technicien.numero_agence = agence.numero_agence and assistant.code_region = \"".$CodeRegAssis['code_region']."\"";
  $resultTechnicien = mysqli_query($bdd,$reqTechnicien);

  if(isset($_POST['submitRechercheInter'])){  
    if(isset($_POST['rechercheT']) and $_POST['rechercheT']!=""){
      $infoTech = explode (" ", $_POST['rechercheT']);
      $nom_technicien = $infoTech[0];
      $prenom_technicien = $infoTech[1];

      $reqMatTechnicien = "SELECT matricule FROM technicien WHERE prenom =\"".$prenom_technicien."\" and  nom =\"".$nom_technicien."\"";
      $resultMatTechnicien = mysqli_query($bdd,$reqMatTechnicien);
      $matT = $resultMatTechnicien ->fetch_array(MYSQLI_ASSOC);

      if($_POST['dateInter']!=""){
        $reqInterv = "SELECT intervention.*, client.nomC, client.prenomC FROM intervention, client, technicien, assistant, agence WHERE client.numero_client = intervention.numero_client and intervention.matricule_technicien=technicien.matricule and technicien.numero_agence = agence.numero_agence and agence.code_region= assistant.code_region and intervention.validation = 0 and intervention.matricule_technicien=\"".$matT['matricule']."\" and intervention.date_visite = \"".$_POST['dateInter']."\" and assistant.code_region =\"".$CodeRegAssis['code_region']."\" ORDER BY intervention.numero_intervention asc";
        $resultReqInterv = mysqli_query($bdd,$reqInterv);
      }

      if($_POST['dateInter']==""){
        $reqInterv = "SELECT intervention.*, client.nomC, client.prenomC FROM intervention,client, technicien, assistant, agence WHERE client.numero_client = intervention.numero_client and intervention.matricule_technicien=technicien.matricule and technicien.numero_agence = agence.numero_agence and agence.code_region= assistant.code_region and intervention.validation = 0 and  intervention.matricule_technicien=\"".$matT['matricule']."\" and assistant.code_region =\"".$CodeRegAssis['code_region']."\" ORDER BY intervention.numero_intervention asc";
        $resultReqInterv = mysqli_query($bdd,$reqInterv);
      }

    }else if($_POST['rechercheT']=="" and $_POST['dateInter']!=""){
      $reqInterv = "SELECT technicien.nom,technicien.prenom ,intervention.*, client.nomC, client.prenomC FROM intervention, client, technicien, assistant, agence WHERE client.numero_client = intervention.numero_client and intervention.matricule_technicien=technicien.matricule and technicien.numero_agence = agence.numero_agence and agence.code_region= assistant.code_region and intervention.validation = 0 and  intervention.date_visite = \"".$_POST['dateInter']."\" and assistant.code_region =\"".$CodeRegAssis['code_region']."\" ORDER BY intervention.numero_intervention asc";
      $resultReqInterv = mysqli_query($bdd,$reqInterv);
    }
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
    <u><h1 style="text-align: center;">Consulter les interventions</h1></u>

    <form method="post" action="" autocomplete="off">
      <!--<?php #echo $reqInterv ?>-->
      <select name="rechercheT" id="rechercheT">
        <option value="">--Choisir un technicien--</option>
        <?php while ($afficheT = $resultTechnicien -> fetch_array(MYSQLI_ASSOC)){?>
            <option><?php echo $afficheT['nom']." ".$afficheT['prenom'];?></option>
         <?php } ?>
      </select>
      <input type="date" name="dateInter">
      <button type="submit" class="btn btn-primary"  name="submitRechercheInter" class="">Valider</button>   
    </form>

    <select multiple class="form-control col-6" size = 5  name = "liste_inter" id = "search">
      <?php 
      if(isset($_POST['rechercheT']) and $_POST['rechercheT']!=""){
          while($affiche = $resultReqInterv -> fetch_array(MYSQLI_ASSOC)){?>
          <option><?php echo $affiche['numero_intervention']." | ".$affiche['date_visite']." | ".$affiche['heure_visite']." | ".$affiche['nomC']." ".$affiche['prenomC']?></option>
          <?php 
            } 
          } 
      if($_POST['rechercheT']=="" and $_POST['dateInter']!=""){
        while($affiche = $resultReqInterv -> fetch_array(MYSQLI_ASSOC)){?>
          <option><?php echo $affiche['numero_intervention']." | ".$affiche['nom']." ".$affiche['prenom']." | ".$affiche['date_visite']." | ".$affiche['heure_visite']." | ".$affiche['nomC']." ".$affiche['prenomC']?></option>
          <?php 
          } 
      }          
      ?>
    </select>

    <form method="post" action =""> 
      <button type="submit" class="btn btn-primary" name="Modifier" data-toggle="modal" data-target="#exampleModal">Modifier</button>
    </form>

    <?php 
    if(isset($_POST['Visualiser']) and isset($_POST['intervention'])){ 
        $infoInter = explode (" | ", $_POST['intervention']);
        $num_Inter = $infoInter[0];

        $reqVisualiser ="SELECT * FROM intervention WHERE intervention.numero_client = client.numero_client and  intervention.numero_intervention =\"".$num_Inter."\"";
        $resultVisualiser = mysqli_query($bdd,$reqVisualiser);
        $affiche2 = $resultVisualiser -> fetch_array(MYSQLI_ASSOC);
      ?>

      <script>
        $( document ).ready(function() {
          $('#Modal').modal('show')  
        });
      </script>

        
     
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier l'intervention</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body" >

          <lo>        
            <li><input type="date" name="datevisite" value="<?php echo $affiche2['date_visite'] ?>"></li>
            <li><input type="text" name="siren" placeholder="Heure" value="<?php  echo $affiche2['heure_visite'] ?>"></li>
          </lo>         
             
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="submit" class="btn btn-primary" name="submitModal">Valider</button>
            </div>
        </div>
      </div>
    </div>  
   <?php 
      } 
    ?> 

  <li><a href="logout.php">Déconnexion</a></li>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>