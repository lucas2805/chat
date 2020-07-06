<?php 

/**
 * Inicializa a $_SESSION e carrega o HTML do início,
 * Mas não verifica se está logado
 */
require_once "../classes.php";
require_once "../html_header.php";

/**
 * Se existir uma $_SESSION redireciona para a página "index.php",
 * Não pode exibir a página login.php para quem já está logado.
 */

if ( isset($_SESSION["usuario"]) )
  header("location:/");

/**
 * Se a quantidade de indices da variável global $_POST for maior que zero (verdadeiro)
 * então o formulário foi enviado, deve tratar os valores contidos nos índices
 */

if ( count($_POST) ) {

	$login = $_POST["login"] ?? null;
	$login = trim($login);

	$senha = $_POST["senha"] ?? null;
	$senha = trim($senha);

    if (empty($login))
		$erro["login"] = "Campo obrigatório";	  
    
    if (empty($senha))
        $erro["senha"] = "Campo obrigatório";    

	if (isset($erro) === false)
	{
		/**
		 * Abre a conexao com o banco de dados
		 */
		$pdo = Database::getInstance();

		/**
		 * Declara um consulta preparada para evitar SQLInjection
		 */
		$stm = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE login = :login");

		$stm->execute([
			":login" => $login
		]);

		$rs = $stm->fetch();

		/**
		 * ($rs) -> Se a consulta retornou alguma linha retorna um array,
		 * Caso contrário retorna FALSE
		 */
		if ($rs && password_verify($senha, $rs["senha"])){

			$_SESSION["usuario"]["id"] = $rs["id"];
			$_SESSION["usuario"]["nome"] = $rs["nome"];
			header("location:/");

		} else 

			$erro["auth"] = "Usuário e/ou senha inválido(s)";

	}      
    
}


?>

<div class="container">



	<div class="row">

    	<div class="offset-lg-4 col-lg-4">

			<h2 class="text-center">Autenticar</h2>	

			<?php
				
				if ($erro["auth"] ?? false)					
					echo Alert::getMessage($erro["auth"]);				
				
			?>

			<form class="mt-4" method="post" autocomplete="off">
		
			<div class="form-group">
				<label for="login">Login</label>
				<input class="form-control col-lg-12<?php echo isset($erro["login"]) ? " is-invalid" : "";?>" type="text" name="login" value="<?php echo $login ?? "";?>">
				<div class="invalid-feedback"><?php echo $erro["login"] ?? "";?></div>
			</div>

			<div class="form-group">
				<label for="senha">Senha</label>
				<input class="form-control col-lg-12<?php echo isset($erro["senha"]) ? " is-invalid" : "";?>" type="password" name="senha" value="<?php echo $senha ?? "";?>">
				<div class="invalid-feedback"><?php echo $erro["senha"] ?? "";?></div>
			</div>

			<div class="form-group">
				<button class="btn btn-success col-lg-12" type="submit" id="Logar no sistema">Entrar</button>
			</div>

			</form>

			<p class="text-center">Não possui cadastro? <a href="/user-add.php">Clique aqui.</p>

		</div>

	</div>

</div>

<?php
require_once "../html_footer.php";