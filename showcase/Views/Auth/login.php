<?php
namespace Showcase\Views\Auth;

use \Showcase\AutoLoad;
use \Showcase\Framework\Session\SessionAlert;
use \Showcase\Framework\HTTP\Links\URL;


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Note</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- STYLE CSS -->
		<link rel="stylesheet" href="<?php echo URL::assets(); ?>css/style.css">

	</head>

	<body>
		<div class="inner">
		</div>
		<div class="wrapper">
			<div class="inner">
				<div class="image-holder">
					<img src="<?php echo URL::assets(); ?>images/images.jpg" alt="">
				</div>
				<form method="post" action='<?php echo AutoLoad::env('APP_URL') ?>auth'>
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
						<a href="<?php echo AutoLoad::env('APP_URL') ?>register" > Créer </a>
					</div>
				</form>
			</div>
		</div>
		<script src="<?php echo URL::assets(); ?>js/jquery-3.3.1.min.js"></script>
		<script src="<?php echo URL::assets(); ?>js/main.js"></script>
	</body>
</html>
