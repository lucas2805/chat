<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

$pdo = Database::getInstance();
$stm = $pdo->query(
	"SELECT salas.id as id, salas.tema as tema, salas.descricao as descricao, disciplinas.nome as disciplina FROM salas LEFT JOIN disciplinas ON disciplinas.id = salas.disciplinas_id ORDER BY disciplinas.nome ASC;"
);

$stm->execute();
$rs_salas = $stm->fetchAll(\PDO::FETCH_ASSOC);

?>


<h2 class="text-center">Salas Disponíveis</h2>


<div class="container">

<div class="row">
	<div class="col-lg-12">
	
		<form>
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
				<button type="submit" class="btn btn-primary mb-2">Pesquisar</button>
				</div>

			</div>
		</form>

	</div>
</div>
    
	<div class="row mt-5">

		<?php 

				foreach ($rs_salas as $v){

					echo '<div class="col-lg-4 mb-4">'.
							'<div class="card">'.
							'<h5 class="card-header">'.$v["disciplina"].'</h5>'.
							'<div class="card-body">'.
								'<h5 class="card-title">'.$v["tema"].'</h5>'.
								'<p class="card-text">'.$v["descricao"].'</p>'.
								'<a href="#" class="btn btn-primary">Entrar</a>'.
							'</div>'.
							'</div>'.
						'</div>';
				}

		?>


	</div>

</div>











<?php

require_once "../html_footer.php";