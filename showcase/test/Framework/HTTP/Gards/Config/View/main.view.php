<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase v1.0</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
				<a class="navbar-brand" href="#">Showcase</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="/">Home</a></li>
					<li><a href="/documentation">Documentation</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					@if(\Showcase\Framework\HTTP\Gards\Auth::guest()){
						display('<li><a href="/login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>');
						display('<li><a href="/register"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>');
					}@else{
						display('<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> @php display(\Showcase\Framework\HTTP\Gards\Auth::user() == null ? '' : \Showcase\Framework\HTTP\Gards\Auth::user()->email);  @endphp </a></li>');
						display('<li><a href="#" id="logout"><span class="glyphicon glyphicon-user"></span> Logout</a></li><form id="logout_form" style="display:none" method="post" action="/logout"></form>');
					}@endif
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
