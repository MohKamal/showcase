<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Note</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="../../ressources/css/style.css">

	</head>

	<body>
		<div class="wrapper">
			<div class="inner">
				<div class="image-holder">
					<img src="../../ressources/images/images.jpg" alt="">
				</div>
				<form method="post" action='/authentification'>
					<h3>Sign Up</h3>
					<div class="form-holder active">
						<input type="text" name="name" placeholder="name" class="form-control" required>
					</div>
					<div class="form-holder">
						<input type="text" name="email" placeholder="e-mail" class="form-control" required>
					</div>
					<div class="form-holder">
						<input type="password" name="password" placeholder="Password" class="form-control" style="font-size: 15px;" required>
					</div>
					<div class="form-login">
						<button  name="register"> Créer </button>
						<button type="submit" name="submit"> Login </button>
						<p> Or <a href="/note">Annuler</a></p>
					</div>
				</form>
			</div>
		</div>
		<script src="../../ressources/js/jquery-3.3.1.min.js"></script>
		<script src="../../ressources/js/main.js"></script>
	</body>
</html>
