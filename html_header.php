<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>TCC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" href="/bootstrap-4.5.0-dist/css/bootstrap.min.css">
  <script src="/jquery/jquery-3.5.1.min.js"></script>
  
  <style>
		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}
		html, body {			
			width: 100%;
			height: 100%;
		}
		ul {
			list-style: none;
		}
		.chat-container {
			width: 100%;
			height: 100%;
			background-color: blanchedalmond;
		}
		.chat-container::after {
			content: "";
			clear: both;
		}
		.chat-usuarios, .chat-mensagens {
			float: left;
			padding: 4rem 1rem;
		}
		.chat-usuarios {
			width: 25%;
			height: 100%;
			background-color: #eee;
		}
		.chat-mensagens {
			width: 75%;
			height: 100%;
			background-color: #ccc;
			overflow-y: auto;
		}

		.chat-formulario {
			position: absolute;
			left: 0;
			bottom: 0;
			width: 100%;
			padding: 0 1rem;;
		}
		.titulo-pagina {
			margin: 6rem 0 2rem 0;
			font-size: 1.8rem;
			font-weight: bold;
			text-align: center;
		}		
		
		.mensagens {
			width: 70%;
			margin: .5rem 0;
			padding: 1rem;
			border-radius: .5rem;
		}
		
		.minhas-mensagens {			
			margin-left: 30%;
			background-color: #ddd;
			
		}

		.mensagens-outros-usuarios {
			margin-right: 30%;
			background-color: #eee;
		}

		.autor-mensagem {
			font-size: .8rem;
			color: #888;
			display: block;
			text-align: right;
		}

		.chat-mensagens div:last-child {
			margin-bottom: 2rem;
		}

		#participantes {
			margin-top: 1.2rem;
			margin-bottom:4rem;
		}

		#participantes li {
			padding: .3rem 0;
		}	
	</style>
</head>
<body>

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/"><strong>TCC</strong></a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarNavDropdown">

		<?php
				if (isset($_SESSION["usuario"]))
					require_once "menu.php";
		?>

	<span class="navbar-text">

		<?php
		
			if (isset($_SESSION["usuario"]))
				echo $_SESSION["usuario"]["nome"] . '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/logout.php">Encerrar sessão</a>';
		?>

	</span>
  </div>
</nav>