<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

if (!isset($_POST["id"]))
	header("location:/sala-consulta.php");

$pdo = Database::getInstance();

/**
 * Recupera os dados da sala (disciplina e tema)
 */
$stm = $pdo->query(

	"SELECT 
		a.id, a.usuarios_id, 
		a.tema, b.nome
		FROM salas a LEFT JOIN disciplinas b ON b.id = a.disciplinas_id 
		WHERE 
		a.id = ".abs((int)$_POST["id"])
	);

$rs_sala = $stm->fetch(\PDO::FETCH_OBJ);

/**
 * Recuperar as 3 últimas mensagens do banco de dados
 */
$stm = $pdo->query(
	"SELECT 
	mensagens.id, 
	mensagens.salas_id, 
	mensagens.usuarios_id AS remetente_id, 
	mensagens.conteudo 
	FROM mensagens 
	LEFT JOIN usuarios ON usuarios.id = mensagens.usuarios_id
	WHERE mensagens.salas_id = ".abs((int)$_POST["id"]));

$rs_mensagens = $stm->fetchAll(\PDO::FETCH_ASSOC);

?>


<div class="container">

	<div class="row">
		<div class="col-lg-4">
			<h4 class="font-weight-bold text-danger"><?php echo $rs_sala->nome;?></h5>
		</div>
		<div class="col-lg-8">
			<h5 class="font-weight-bold text-info"><?php echo $rs_sala->tema;?></h5>			
		</div>		
	</div>

	<style>
		
		#usuarios div {
			max-witdh: 30%;
		}
		
	</style>

	<div class="bg-light" style="display:table; width: 100%; height:20rem; box-sizing:border-box; border-radius:.5rem;">

		<div id="usuarios" style="float:left; width: 30%; max-height:20rem; overflow-y:auto;">			
			<div class="pt-3 pl-3 pr-3 text-info">Usuário A</div>
		</div>		

		<div class="p-2" id="mensagens" style="float:left; width: 70%; max-height:20rem; overflow-y:auto;">

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
			<div class="col-lg-8">
				<input class="form-control" type="text" name="mensagem" id="mensagem" placeholder="Digite sua mensagem aqui...">
			</div>
			<div class="col-lg-2">
				<button type="submit" class="btn btn-success btn-block">Enviar</button>
			</div>
			<div class="col-lg-2">
				<button type="submit" class="btn btn-danger btn-block">Sair da sala</button>
			</div>			
		</div>
	</form>

</div>


<?php


require_once "../html_footer.php";