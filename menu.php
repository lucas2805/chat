<?php

$home_active = [
	"/",
	"/index.php"
];

$bate_papo_active = [
	"/sala-nova.php",
	"/sala-consulta.php"
];

$minha_conta_active = [
	"/user-update.php",
	"/user-password.php"
];

;?>

<ul class="navbar-nav mr-auto">

		<li class="nav-item<?php echo in_array($_SERVER["SCRIPT_NAME"], $home_active) ? " active" : "";?>">	  
			<a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
		</li>		

		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle<?php echo in_array($_SERVER["SCRIPT_NAME"], $bate_papo_active) ? " active" : "";?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Bate Papo
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="/sala-nova.php">Criar Sala</a>
				<a class="dropdown-item" href="/sala-consulta.php">Visualizar Salas</a>
			</div>
		</li>
	
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle<?php echo in_array($_SERVER["SCRIPT_NAME"], $minha_conta_active) ? " active" : "";?>" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				Minha Conta
			</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				<a class="dropdown-item" href="/user-update.php">Atualizar dados</a>
				<a class="dropdown-item" href="/user-password.php">Alterar senha</a>
			</div>
		</li>
</ul>