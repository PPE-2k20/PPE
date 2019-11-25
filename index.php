<?php
	include_once 'db_connect.php';

	$error = isset($_GET['error'])?$_GET['error']:"";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ca$hCa$h</title>
	<meta charset="utf-8">
</head>

<body>
	<h1>Ca$hCa$h</h1>
	<form method="post"action="connect.php">
		<input type="text" id="login" name="login" placeholder="Utilisateur">
		<input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
		<input type="submit" class="" value="Valider">
	</form>		
</body>
</html>
