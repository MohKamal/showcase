<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="@{{Assets}}/images/favicon.ico" />
		<!-- STYLE CSS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
		<link rel="stylesheet" href="@{{Bootsrap-style}}">
		<style>
			body{background: #fff;}
			.banner{position: absolute; text-align: center; top:50%; left:50%; transform:translate(-50%,-50%);}
			.banner span{color: #000; text-transform: uppercase; display: block; font-family:open sans;}
			.banner .text_1{font-size: 60px; font-weight: 700; letter-spacing:8px; margin-bottom: 20px; background: #fff; position: relative; animation: text 3s 1; z-index: 999;}
			.banner .text_2{font-size: 30px; color: #e62424; position: relative;}
			.text_2::before{ position: absolute;
			content: ''; top:0;left: 0;width: 0;height: 100%;background-color: black; transform-origin:left;  transition:width 1s cubic-bezier(0.46, 0.03, 0.52, 0.96); z-index:-1; overflow: hidden;}

			.text_2:hover::before{width: 100%;}
			.banner .text_2:hover{font-style: italic; transition: ease 2s;}


			@keyframes text{
				0%{
					color: black;
					margin-bottom: -40px;
					
				}
				30%{
					letter-spacing: 25px;
					margin-bottom: -40px;
				}
				80%{
					letter-spacing: 8px;
					margin-bottom: -40px;
				}
			}

			@media (min-width: 320px) and (max-width: 480px) {
				.banner .text_1{font-size: 45px;}
				.banner .text_2{font-size: 20px;}
			}
		</style>
	</head>

	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<a class="navbar-brand" href="#">Showcase</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
				<li class="nav-item active">
					<a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/documentation">{{$doc}}</a>
				</li>
				@if(Auth::guest())
					<li class='nav-item'><a class='nav-link' href='/login'>Login</a></li>
					<li class='nav-item'><a class='nav-link' href='/register'>Register</a></li>
				@else
					<li class='nav-item'><a class='nav-link disabled' href='#'> {{Auth::user() == null ? '' : \Showcase\Framework\HTTP\Gards\Auth::user()->username}} </a></li>
					<li class='nav-item'><a class='nav-link' href='#' id='logout'>Logout</a></li><form id='logout_form' style='display:none' method='post' action='/logout'>@csrf</form>
				@endif
				</ul>
			</div>
		</nav>
		@render()
		<script src="@{{Jquery}}"></script>
		<link rel="stylesheet" href="@{{Bootsrap-script}}">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script>
			$("#logout").on('click', function(e){
				e.preventDefault();
				$("#logout_form").submit();
			})
		</script>
	</body>
</html>
