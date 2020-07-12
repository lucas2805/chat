<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

$pdo = Database::getInstance();

/**
 * Recuperando as disciplinas para preencher o select do formulário
 */
$stm = $pdo->query("SELECT id, nome FROM disciplinas ORDER BY nome ASC;");
$rs_select_disciplinas = $stm->fetchAll(\PDO::FETCH_OBJ);


/**
 *  Recuperar as salas cadastradas no banco de dados
 */

$sql = "SELECT salas.id as id, salas.tema as tema, salas.descricao as descricao, 
	disciplinas.nome as disciplina FROM salas 
	LEFT JOIN disciplinas ON disciplinas.id = salas.disciplinas_id";

$where = " WHERE salas.id IS NOT NULL";

$disciplina = (int)($_GET["disciplina"] ?? null);
$tema = trim(($_GET["tema"] ?? null));
$descricao = trim(($_GET["descricao"] ?? null));

if ($disciplina){
	$where .= " AND disciplinas.id = :disciplina";
	$bind[":disciplina"] = $disciplina;
}

if (strlen($tema)){
	$where .= " AND salas.tema LIKE CONCAT ('%',:tema,'%')";
	$bind[":tema"] = $tema;
}

if (strlen($descricao)){
	$where .= " AND salas.descricao LIKE CONCAT ('%',:descricao,'%')";
	$bind[":descricao"] = $descricao;
}

$stm = $pdo->prepare($sql.$where);

$stm->execute($bind ?? []);

$rs_salas = $stm->fetchAll(\PDO::FETCH_ASSOC);

?>





<div class="container">

	<h2 class="titulo-pagina">Salas Disponíveis</h2>
	
		<form autocomplete="off">
			<div class="form-row">
				<div class="col-lg-3 mb-4">
					<label for="disciplina">Disciplina</label>
					<select id="disciplina" name="disciplina" class="custom-select">
						<option value=""></option>
						<?php
								foreach($rs_select_disciplinas as $v){
									$selected = $v->id == $_GET["disciplina"] ? " selected" : "";
									echo "<option value=\"{$v->id}\"{$selected}>{$v->nome}</option>";
								}
						?>
					</select>
				</div>
			
				<div class="col-lg-4 mb-4">
					<label for="tema">Tema</label>
					<input type="text" name="tema" id="tema" class="form-control" maxlength="255">
				</div>

				<div class="col-lg-5 mb-4">
					<label for="descricao">Descrição</label>
					<input type="text" name="descricao" id="descricao" class="form-control" maxlenght="255">
				</div>

			</div>	

			<div class="row mt-2">
				<div class="offset-lg-8 col-lg-2 col-6">
					<a href="/sala-consulta.php" class="btn btn-primary btn-block">Mostrar todas</a>
				</div>
				<div class="col-lg-2 col-6">
					<button type="submit" class="btn btn-success btn-block">Pesquisar</button>
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