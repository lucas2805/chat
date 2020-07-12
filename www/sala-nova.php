<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

/**
 * Carregar o elemento select que contém todas as disciplinas cadastradas 
 */
$pdo = Database::getInstance();
$stm = $pdo->query("SELECT id, nome FROM disciplinas ORDER BY nome ASC;");
$rs_disciplinas = $stm->fetchAll(\PDO::FETCH_ASSOC);

if (count($_POST)){

	$disciplinas_id = (int)($_POST["disciplinas_id"] ?? null);
	$tema = trim($_POST["tema"] ?? null);
	$descricao = trim($_POST["descricao"] ?? null);

	$disciplinas_id ?: $erro["disciplinas_id"] = "Escolha uma disciplina";
	$tema ?: $erro["tema"] = "A escolha do tema é obrigatória";
	$descricao ?: $erro["descricao"] = "Descrição é obrigatória";

	if (!isset($erro)){
		
		try {

			$stm = $pdo->prepare("INSERT INTO salas (disciplinas_id, usuarios_id, tema, descricao) VALUES (:disciplinas_id, :usuarios_id, :tema, :descricao)");
			$stm->execute([
				":disciplinas_id" => $disciplinas_id,
				":usuarios_id" => $_SESSION["usuario"]["id"],
				":tema" => $tema,
				":descricao" => $descricao
			]);

			$message["text"] = "Sala criada com sucesso.";
			$message["type"] = "alert-success";

			$_POST = [];

		} catch (\PDOException $e){

			if ($e->errorInfo[1] == 1062){
				$message["text"] = "Esta sala já existe.";
				$message["type"] = "alert-warning";
			}
		}
	}
}


?>




<div class="container">	
	
	<div class="row">

		<div class="offset-lg-4 col-lg-4"> 
			
			<h2 class="titulo-pagina">Criar Sala</h2>

			<?php echo isset($message) ? Alert::getMessage($message["text"], $message["type"]) : null; ?>
	
			<form class="" method="post">

				<div class="form-group">
					<label class="mr-sm-2" for="disciplinas_id">Disciplina</label>
					<select class="custom-select mr-sm-2<?php echo isset($erro["disciplinas_id"]) ? " is-invalid" : "";?>" name="disciplinas_id" id="disciplinas_id">
						<option value=""></option>					
						<?php
								foreach ($rs_disciplinas as $v){
									$selected = $_POST["disciplinas_id"] == $v["id"] ? " selected" : "";
									echo '<option value="'.$v["id"].'"'.$selected.'>'.$v["nome"].'</option>';
								}
						?>
					</select>
					<div class="invalid-feedback"><?php echo $erro["disciplinas_id"] ?? "";?></div>
				</div>

				<div class="form-group">
					<label for="tema">Tema escolhido</label>
					<input class="form-control col-lg-12<?php echo isset($erro["tema"]) ? " is-invalid" : "";?>" type="text" maxlength="255" name="tema" value="<?php echo $_POST["tema"] ?? "";?>">
					<div class="invalid-feedback"><?php echo $erro["tema"] ?? "";?></div>
				</div>
		
				<div class="form-group">
					<label for="descricao">Descrição do tema abordado</label>
					<textarea class="form-control<?php echo isset($erro["descricao"]) ? " is-invalid" : "";?>" name="descricao" rows="4"><?php echo $_POST["descricao"] ?? "";?></textarea>
					<div class="invalid-feedback"><?php echo $erro["descricao"] ?? "";?></div>
				</div>
			
				<div class="form-group">
					<button class="btn btn-success col-lg-12" type="submit">Criar</button>
				</div>

			</form>
		</div>
	</div>
</div>
 
      
<?php

require_once "../html_footer.php";