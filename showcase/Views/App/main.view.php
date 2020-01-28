<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase v1.0</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- STYLE CSS -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
		<link rel="stylesheet" href="@{{Assets}}/bootstrap/css/bootstrap.min.css">
		<style>
			body{background: #000;}
			.banner{position: absolute; text-align: center; top:50%; left:50%; transform:translate(-50%,-50%);}
			.banner span{color: #fff; text-transform: uppercase; display: block; font-family:open sans;}
			.banner .text_1{font-size: 60px; font-weight: 700; letter-spacing:8px; margin-bottom: 20px; background: #000; position: relative; animation: text 3s 1;     z-index: 999;}
			.banner .text_2{font-size: 30px; color: #e62424; position: relative;}
			.text_2::before{ position: absolute;
			content: ''; top:0;left: 0;width: 0;height: 100%;background-color: white; transform-origin:left;  transition:width 1s cubic-bezier(0.46, 0.03, 0.52, 0.96);  z-index:-1; overflow: hidden;}

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
		</style>
	</head>

	<body>
		<div class="wrapper">
			<div class="inner">
			<section class="banner">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12">
							<span class="text_1">Showcase</span>
						
							<span class="text_2">Simple and Powerful
							<div class="bg_hover">
							</div>
							</span>
						
						</div>
					</div>
				</div>
			</section>
			</div>
		</div>
		<script src="@{{Assets}}/js/jquery-3.3.1.min.js"></script>
		<link rel="stylesheet" href="@{{Assets}}/bootstrap/js/bootstrap.min.js">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</body>
</html>
