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

  $req = "SELECT * FROM intervention WHERE Validation = 0";
  $result=mysqli_query($bdd,$req);


  if(isset($_POST['intervention'])){
    $numInter = $_POST['intervention'];
    $req = "UPDATE intervention SET Validation= 1 Where numero_intervention = ".$numInter;
    $result=mysqli_query($bdd,$req);
    $req = "SELECT * FROM intervention WHERE Validation = 0";
    $result=mysqli_query($bdd,$req);
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
	<select name="intervention" id="intervention">
    	<option value="">--Choisir une intervention--</option>
    	<?php while ($affiche = $result -> fetch_array(MYSQLI_ASSOC)) {?>
    	    <option value="<?php echo $affiche['numero_intervention'];?>"><?php echo $affiche['numero_intervention'];?></option>
   		 <?php } ?>
	</select>
	<input type="submit" value="Valider">
	</form>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Valider	
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Validation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form name="valid">
		  <div class="form-group">
		    <label for="numSerie">Numéro de série</label>
		    <input type="text" class="form-control" id="numSerie" placeholder="Numéro de série">
		  </div>
		  <div class="form-group">
		    <label for="Commentaire">Commentaire</label>
		    <textarea class="form-control" id="Commentaire" rows="3"></textarea>
		  </div>
		  <div class="form-group">
		    <label for="nbHeure">Temps d'intervention</label>
		    <input type="text" class="form-control" id="nbHeure" placeholder="Temps d'intervention">
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
   </body>
</html>