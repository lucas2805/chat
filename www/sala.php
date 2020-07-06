<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

$pdo = Database::getInstance();





/**
 * Recuperar as 3 últimas mensagens do banco de dados
 */
$stm = $pdo->query("SELECT * FROM mensagens ORDER BY id DESC limit 0,3;");
$rs_mensagens = $stm->fetchAll(\PDO::FETCH_ASSOC);

?>


<div class="container">

	<div class="row">
		<div class="col-lg-3">
			<h3 class="font-weight-bold text-danger">Disciplina</h3>
		</div>
		<div class="col-lg-9">
			<h4 class="font-weight-bold text-info">Tema</h4>			
		</div>
		<div class="col-lg-12">
			<hr class="my-2">
			<p class="lead">Aqui vai a descrição do tema da sala.</p>
		</div>
	</div>

	<div class="row">

		<div class="col-lg-3">
			<div id="usuarios" style="background-color:#eee; height: 20rem;"></div>
		</div>
		<div class="col-lg-9">
			<div id="mensagens" style="background-color:#eee; height: 20rem;"></div>
		</div>

	</div>
	
	<form method="POST">
		<div class="row mt-4">
			<div class="col-lg-10">
				<input class="form-control" type="text" name="mensagem" id="mensagem" placeholder="Digite sua mensagem aqui...">
			</div>
			<div class="col-lg-2">
				<button type="submit" class="btn btn-success btn-block">Enviar</button>
			</div>
		</div>
	</form>

</div>


<?php

require_once "../html_footer.php";