<?php 
require_once "../html_header.php";


// Se estiver logado a variável vai existir e o usuário será redirecionado imediatamente para a index.php
if ( isset($_SESSION["user"]) )
  header("location:/");

// Se a quantidade de índices na variável $_POST for maior que zero entra no IF.
// Lembrando que o valor zero é o mesmo que false

$matricula = $_POST["matricula"] ?? null;
$senha = $_POST["senha"] ?? null;

$matricula = trim($matricula);
$senha = trim($senha);

if ( count($_POST) ) {

    /**
     * OS CAMPOS MATRICULA E SENHA SÃO OBRIGATÓRIOS
     * 
     * O ponto de exclamação significa: Se $matrícula é igual a zero ou false.
     * Ex.: SE não $matrícula, ou $matricula == false
     * Se atender ao critério executa o bloco do IF
    */

    if (!$matricula)
        $erro["matricula"] = "Obrigatório valor numérico maior que zero";     
    
    if (strlen($senha) === 0 )
        $erro["senha"] = "Comprimento de senha inválido";    

    if (!isset($erro))
        echo "<h4>Próxima etapa, verificar no banco o usuário e senha ...</h4>";
    
}

?>

<div class="container">

	<div class="row">

    	<div class="offset-lg-4 col-lg-4">
			<h2 class="text-center">Login no Site</h2>		

			<form class="mt-4" method="post">
		
			<div class="form-group">
				<label for="matricula">Matrícula</label>
				<input class="form-control col-lg-12<?php echo isset($erro["matricula"]) ? " is-invalid" : "";?>" type="text" maxlength="6" id="matricula" name="matricula" value="<?php echo $matricula ?? null;?>">
				<div class="invalid-feedback"><?php echo $erro["matricula"] ?? "";?></div>
			</div>

			<div class="form-group">
				<label for="senha">Senha</label>
				<input class="form-control col-lg-12<?php echo isset($erro["senha"]) ? " is-invalid" : "";?>" type="password" maxlength="6" id="senha" name="senha" value="<?php echo $senha ?? null;?>">
				<div class="invalid-feedback"><?php echo $erro["senha"] ?? "";?></div>
			</div>
		
			<div class="form-group">
				<button class="btn btn-success col-lg-12" type="submit" id="Logar no sistema">Acessar conteúdo</button>
			</div>

			</form>

		</div>

	</div>

</div>

<?php
require_once "../html_footer.php";