<?php  
session_start();
  if (!isset ($_SESSION['login'])) {
    header("location: index.php");
    //Si une personne non connecter essaie d'acceder a la page il est renvoyé vers index.php
  }elseif ($_SESSION['statut']=="technicien") {
    header("location: accueil_A.php");
    //Si un assistant essaie d'acceder aux page technicien il est renvoyé vers la page assistant
  }

  $bdd = mysqli_connect("localhost","root","","ppe");
  $nomA = "SELECT nom , prenom FROM utilisateur, assistant Where assistant.matricule = utilisateur.matricule and login =\"".$_SESSION['login']."\"";
  $reqNom = mysqli_query($bdd,$nomA);
  $affiche = $reqNom->fetch_array(MYSQLI_ASSOC);

  $reqNbContrat = "SELECT COUNT(*) AS nbContrat FROM contrat_maintenance WHERE DATEDIFF(date_echeance,CURRENT_DATE) < 31";
  $resultNbContrat = mysqli_query($bdd, $reqNbContrat);
  $afficheNbContrat = $resultNbContrat -> fetch_array(MYSQLI_ASSOC);

  //inclusion de la connexion à la base de données
  include_once 'db_connect.php';
  //echo (mysqli_error($connexion_a_la_bdd));

?>

<!DOCTYPE html>
<html>

 <head>
   <meta charset="utf-8">
	<title>Ca$hCa$h</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>

  <body>
  	<h2>Page accueil Assistants</h2>
    <p><?php echo $affiche['nom']; ?> <?php echo $affiche['prenom']; ?></p>
  	<a href="recherche_A.php"/><center><button>Page de recherche</button></center></a>
  	<a href="affecterV_A.php"/><center><button>Affecter une visite</button></center></a>
  	<a href="consulteInter_A.php"/><center><button>Consulter les interventions</button></center></a>
  	<a href="stat_A.php"/><center><button>Statistique</button></center></a>

    <form method="post" action ="">
     <button type="submit" class="btn btn-primary" name="Contrat" data-toggle="modal" data-target="#ModalA">Le nombre de contrat arrivant à la fin : <?php echo $afficheNbContrat['nbContrat']?></button>
    </form>

    <?php 

      if(isset($_POST['Contrat'])){ 

        $reqContrat = "SELECT client.*, contrat_maintenance.* FROM contrat_maintenance, client WHERE contrat_maintenance.numero_client = client.numero_client and DATEDIFF(date_echeance,CURRENT_DATE) < 31";
        $resultContrat = mysqli_query($bdd, $reqContrat); 

      ?>

      <script>
        $( document ).ready(function() {
          $('#ModalA').modal('show')  
        });
      </script>

      <div class="modal fade" id="ModalA" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Contrat arrivant à la fin</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" >
              <table class="table table-bordered table-sm">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>n°Contrat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while($afficheContrat = $resultContrat -> fetch_array(MYSQLI_ASSOC)){?>
                    <td><?php echo $afficheContrat['nomC'] ?></td>
                    <td><?php echo $afficheContrat['prenomC'] ?></td>
                    <td><?php echo $afficheContrat['numero_contrat'] ?></td>
                <?php 
                  }
                ?>

                </tbody>
              </table>

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