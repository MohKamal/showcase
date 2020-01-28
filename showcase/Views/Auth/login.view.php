<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Note</title>
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
				<form method="post" action='@{{Base}}/auth'>
					<h3>Sign Up</h3>
					<?php
						if(!is_null(SessionAlert::Show())){
							foreach(SessionAlert::Show() as $msg)
								echo $msg;
							SessionAlert::Clear();
						}
					?>
					<div class="form-holder">
						<input type="email" name="email" placeholder="e-mail" class="form-control" required>
					</div>
					<div class="form-holder">
						<input type="password" name="password" placeholder="Password" class="form-control" style="font-size: 15px;" required>
					</div>
					<div class="form-login">
						<button type="submit"> Login </button>
						<a href="@{{Base}}/register" > Créer </a>
					</div>
				</form>
			</div>
		</div>
		<script src="@{{Assets}}/js/jquery-3.3.1.min.js"></script>
		<script src="@{{Assets}}/js/main.js"></script>
	</body>
</html>