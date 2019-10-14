<?php  
	if(isset($_POST['form'])){
		$login = $_POST['Utilisateur'];
		$mdp = $_POST['Mdp'];

		if($utilisateur == 'Assistant'&& $mdp=='Assistant'){
            $c = new PDO('mysql:host=localhost;dbname=ppe','Assistant','Assistant');
            header('Location:Assistant.php');
            $connected = true;
        }

		if($utilisateur == 'Technicien'&& $mdp=='Technicien'){
            $c = new PDO('mysql:host=localhost;dbname=ppe','Technicien','Technicien');
            header('Location:Technicien.php');
            $connected = true;
        }

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ca$hCa$h</title>
	<meta charset="utf-8">
</head>
<body>
	<h1>Ca$hCa$h</h1>
	<form>
		<input type="text" id="login" placeholder="Utilisateur">
		<input type="password" id="mdp" placeholder="Mot de passe">
		<input type="submit" class="" value="Valider">
	</form>		
</body>
</html>