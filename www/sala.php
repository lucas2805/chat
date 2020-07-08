<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

if (!isset($_POST["id"]))
	header("location:/sala-consulta.php");

$pdo = Database::getInstance();





/**
 * Recuperar as 3 últimas mensagens do banco de dados
 */
$stm = $pdo->query("SELECT mensagens.id, mensagens.salas_id, mensagens.usuarios_id AS remetente_id, mensagens.conteudo FROM mensagens LEFT JOIN usuarios ON usuarios.id = mensagens.usuarios_id");
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
	</div>

	<style>
		
		#usuarios div {
			max-witdh: 30%;
		}
		
	</style>

	<div class="bg-light" style="display:table; width: 100%; height:25rem; box-sizing:border-box; border-radius:.5rem;">

		<div id="usuarios" style="float:left; width: 30%; max-height:25rem; overflow-y:auto;">			
			<div class="pt-3 pl-3 pr-3 text-info">Participante X</div>
		</div>		

		<div class="p-2" id="mensagens" style="float:left; width: 70%; max-height:25rem; overflow-y:auto;">

			<?php 
				foreach($rs_mensagens as $v){

					if ($v["remetente_id"] == $_SESSION["usuario"]["id"])
						$class = 'offset-lg-4 col-lg-8 bg-dark text-light p-2 pl-3 rounded';
					else 
						$class = 'col-lg-8 bg-secondary text-light p-2 pl-3 rounded';

						echo "<div class='row m-2'>
									<div class='".$class."'>
										{$v["conteudo"]}
									</div>
								</div>";									
				}
			?>

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