<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase - Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="@{{Assets}}/css/style.css">

	</head>

	<body>
		<div class="inner">
		</div>
		<div class="wrapper">
			<div class="inner">
				<div class="image-holder">
					<img src="@{{Assets}}/images/images.jpg" alt="">
				</div>
				<form method="post" action='/auth'>
					@csrf
					<h3>Sign Up</h3>
					<div class="form-holder">
						<input type="email" name="email" placeholder="e-mail" class="form-control" required>
					</div>
					<div class="form-holder">
						<input type="password" name="password" placeholder="Password" class="form-control" style="font-size: 15px;" required>
					</div>
					<div class="form-login">
						<button type="submit"> Login </button>
						<a href="/register"> Créer </a>
					</div>
				</form>
			</div>
		</div>
		<script src="@{{Jquery}}"></script>
		<script src="@{{Assets}}/js/main.js"></script>
	</body>
</html>
