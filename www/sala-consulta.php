<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

$pdo = Database::getInstance();


/**
 * Carregar o elemento select que contém todas as disciplinas cadastradas 
 */
$stm = $pdo->query("SELECT id, nome FROM disciplinas ORDER BY nome ASC;");
$rs_disciplinas = $stm->fetchAll(\PDO::FETCH_ASSOC);


/**
 *  Recuperar as salas cadastradas no banco de dados
 */
$stm = $pdo->query(
	"SELECT salas.id as id, salas.tema as tema, salas.descricao as descricao, disciplinas.nome as disciplina FROM salas LEFT JOIN disciplinas ON disciplinas.id = salas.disciplinas_id"
);

$stm->execute();
$rs_salas = $stm->fetchAll(\PDO::FETCH_ASSOC);

?>





<div class="container">

	<h2 class="titulo-pagina">Salas Disponíveis</h2>
	
		<form autocomplete="off">
			<div class="form-row align-items-center mt-4">
				<div class="col-lg-3">
				<label class="sr-only" for="disciplina">Disciplina</label>
				<input type="text" name="disciplina" id="disciplina" class="form-control mb-2" placeholder="Disciplina...">
				</div>
			
				<div class="col-lg-3">
				<label class="sr-only" for="tema">Tema</label>
				<input type="text" name="tema" id="tema" class="form-control mb-2" placeholder="Tema...">
				</div>

				<div class="col-lg-4">
				<label class="sr-only" for="descricao">Tema</label>
				<input type="text" name="descricao" id="descricao" class="form-control mb-2" placeholder="Descricao...">
				</div>

				<div class="col-auto">
				<button type="submit" class="btn btn-success mb-2">Pesquisar</button>
				</div>

			</div>
		</form>
    
		<div class='card-columns mt-5'>

		<?php 

				foreach ($rs_salas as $v){

					echo "<div class='card'>
							<div class='card-body'>	
								<h4 class='card-title font-weight-bold text-danger'>{$v["disciplina"]}</h4>																							
								<h5 class='card-title'>{$v["tema"]}</h5>
								<p class='card-text'>{$v["descricao"]}</p>					
							
								<form method='post' action='sala.php' class='text-right'>
									<input type='hidden' name='id' value='".$v["id"]."'>
									<button type='submit' class='btn btn-primary'>Entrar</a>
								</form>
							</div>							
						</div>";	
				}

		?>

		</div><!-- Fecha .card-columns -->

</div>










<?php

require_once "../html_footer.php";