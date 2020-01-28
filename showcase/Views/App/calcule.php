<?php
namespace Showcase\Views\App;

use \Showcase\Framework\Initializer\AutoLoad;
use \Showcase\Framework\Session\SessionAlert;
use \Showcase\Models\User;
use \Showcase\Models\Degree;
use \Showcase\Framework\HTTP\Links\URL;


?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Your Espace</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="<?php echo URL::assets(); ?>fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="<?php echo URL::assets(); ?>css/style1.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
	</head>

	<body background="images/image1.jpg">

		<div class="wrapper">
			<div class="inner">
				<a href="<?php echo AutoLoad::env('APP_URL') ?>logout" class="btn btn-primary">Logout</a>
				<form method="post" action="/degree/create" >
					<h3>Calcul your note</h3>
					<div class="form-row">
						<div class="form-wrapper">
							<label for="">Bonjour <?php echo User::Current()->username;?>,</label>
							<?php
								if(!is_null(SessionAlert::Show())){
									foreach(SessionAlert::Show() as $msg)
										echo $msg;
									SessionAlert::Clear();
								}
							?>
						</div>
					</div>
					<div class="form-row">
						<div class="form-wrapper">
							<label for="">UML : </label>
							<input name="uml" class="form-control" placeholder="between 0 and 20">
						</div>
						<div class="form-wrapper">
							<label for="">Programmation Web: </label>
							<input name="programmation" class="form-control" placeholder="between 0 and 20">
						</div>
					</div>
					<div class="form-row">
					<div class="form-wrapper">
						<label for="">Compilation : </label>
						<input class="form-control" placeholder="between 0 and 20" name="compilation">
					</div>
					<div class="form-wrapper">
						<label for="">Artificial intelligence : </label>
						<input class="form-control" placeholder="between 0 and 20" name="ai">
					</div>
					</div>
					<button data-text="Calcul" class="btn primary-btn" nom="calcul">
						<span>Calcul</span>
					</button>
				</form>
			</div>
		</div>


		<!-- Editable table -->
		<div class="wrapper" style='margin-left:10%;'>
				<div class="card">
				<h3 class="card-header text-center font-weight-bold text-uppercase py-4">Vos Note</h3>
				<div class="card-body">
					<div id="table" class="table-editable">
					<span class="table-add float-right mb-3 mr-2"><a href="#!" class="text-success"><i class="fas fa-plus fa-2x"
							aria-hidden="true"></i></a></span>
					<table class="table table-bordered">
						<tr>
							<th class="text-center">Nom</th>
							<th class="text-center">Programmation Web</th>
							<th class="text-center">Compilation</th>
							<th class="text-center">Artificial intelligence</th>
							<th class="text-center">UML</th>
							<th class="text-center">Resulta</th>
							<th width="100px">Action</th>
						</tr>
						<?php
						foreach(Degree::getAllByEmail(User::Current()->email) as $line){
						?>
							<tr>
								<td><?php echo User::Current()->username ?></td>
								<td><a href="" class="update" data-name="programmation" data-type="text" data-pk="<?php echo User::Current()->email ?>" data-title="Entrez une note"><?php echo $line->programmation ?></a></td>
								<td><a href="" class="update" data-name="compilation" data-type="text" data-pk="<?php echo User::Current()->email ?>" data-title="Entrez une note"><?php echo $line->compilation ?></a></td>
								<td><a href="" class="update" data-name="ai" data-type="text" data-pk="<?php echo User::Current()->email ?>" data-title="Entrez une note"><?php echo $line->ai ?></a></td>
								<td><a href="" class="update" data-name="uml" data-type="text" data-pk="<?php echo User::Current()->email ?>" data-title="Entrez une note"><?php echo $line->uml ?></a></td>
								<td><?php echo $line->result(); ?></td>
								<td><button class="btn btn-danger btn-sm">Delete</button></td>
							</tr>
						<?php } ?>

						</table>
					</div>
				</div>
				</div>
		</div>
		<!-- Editable table -->

		<script src="<?php echo URL::assets(); ?>js/main.js"></script>
		<script  type="text/javascript">
			$('.update').editable({
				url: '/degree/update',
				type: 'text',
			});
		</script>
	</body>
</html>
