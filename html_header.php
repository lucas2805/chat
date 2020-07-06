<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>TCC_ETC</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body class="mt-5 pt-5">

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="/"><strong>TCC_ETEC</strong></a>
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