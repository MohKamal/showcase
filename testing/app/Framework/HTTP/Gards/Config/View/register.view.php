<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase - Register</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="@{{Bootsrap-style}}">
		<link rel="stylesheet" href="@{{Styles}}/style.css">

	</head>

	<body>
		<div class="wrapper">
			<div class="inner">
				<div class="image-holder">
					<img src="@{{Assets}}/images/images.jpg" alt="">
				</div>
				<form method="post" action='/newregister'>
					@foreach($errors as $error)
						<div class='alert alert-danger' role='alert'> @display $error @enddisplay </div>
					@endforeach
					<h3>Sign Up</h3>
					<div class="form-holder active">
						<input type="text" name="username" placeholder="name" class="form-control" >
					</div>
					<div class="form-holder">
						<input type="text" name="email" placeholder="e-mail" class="form-control" >
					</div>
					<div class="form-holder">
						<input type="password" name="password" placeholder="Password" class="form-control" style="font-size: 15px;" >
					</div>
					<div class="form-login">
						<button type="submit" name="submit"> Créer </button>
						<a href="/login" > Login </a>
					</div>
				</form>
			</div>
		</div>
		<script src="@{{Scripts}}jquery-3.3.1.min.js"></script>
		<script src="@{{Scripts}}main.js"></script>
	</body>
</html>
