<?php
	include_once 'db_connect.php';
	$error = isset($_GET['error'])?$_GET['error']:"";
?>

<!DOCTYPE html>
<html>
    
<head>
	<title>CashCash</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="icon" href="logo.ico" />
</head>

<body>
	<div class="container-contact100">
		<div class="wrap-contact100">
			<div class="user_card">
				<div align="center" style="font-size: 25px"><b>Cashcash</b></div>
				<br>
				<div class="row">
					<div class="offset-md-2 col-8">
						<form class="contact100-form validate-form" method="post" action="connect.php">
							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-user"></i></span>
								</div>

								<input type="text" name="login" id="login" class="form-control input_user" value="" placeholder="Nom d'utilisateur" required>
							</div>

							<div class="input-group mb-2">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fas fa-key"></i></span>
								</div>
								<input type="password" name="mdp" id="mdp" class="form-control input_pass" value="" placeholder="Mot de passe" required>
							</div>

							<div class="d-flex justify-content-center mt-3 login_container">
					 			<button type="submit" name="button" class="btn btn-success">Connexion</button>
					   		</div>
						</form>
					</div>
				<?php if ($error == "Mauvais mot de passe veuillez reessayer" or $error == "Utilisateur inconnu veuillez reessayer") { ?>
					<script type="text/javascript">
						setTimeout(function() {
						    $('#mydiv').fadeOut('slow');
						}, 2000);
					</script>	

					<div class="offset-md-1 col-12" id="mydiv">
						<span class="text-black" style="padding:10px; color:red;"><strong><?php echo utf8_encode($error); ?></strong></span>
					</div>
				<?php } ?>
				</div>
			</div>
		</div>
	</div>

	
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>