<?php 
require_once "../html_header.php";


$disciplinas = $_POST["disciplinas"] ?? null;

$disciplinas = trim($disciplinas);

if ( count($_POST) ) {

    if (!$disciplinas)
		$erro["disciplinas"] = "Disciplina Não Selecionada";
		
		if (!isset($erro))
        echo "<h4>Disciplina Cadastrada.</h4>";
    
}
?>
<div class="container">

	<div class="row">

    	<div class="offset-lg-4 col-lg-4">
			<h2 class="text-center">Cadastro de disciplina</h2>		

			<form class="mt-4" method="post">
		
			<div class="form-group">
				<label for="disciplinas">Disciplinas</label>
				<input class="form-control col-lg-12<?php echo isset($erro["disciplinas"]) ? " is-invalid" : "";?>" type="text" maxlength="100" id="disciplinas" name="disciplinas" value="<?php echo $disciplinas ?? null;?>">
				<div class="invalid-feedback"><?php echo $erro["disciplinas"] ?? "";?></div>
            </div>
            <div class="form-group">
				<button class="btn btn-success col-lg-12" type="submit" id="Cadastrar disciplina">Cadastrar disciplina</button>
			</div>
           
			</form>

		</div>

	</div>

</div>

<?php
require_once "../html_footer.php";
?>

            
