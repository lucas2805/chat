<?php 

/**
 * Inicializa a $_SESSION e carrega o HTML do início,
 * Mas não verifica se está logado
 */

require_once "../html_header_public.php";

/**
 * Se existir uma $_SESSION redireciona para a página HOME,
 * Não pode exibir login para quem já está logado.
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
		$erro["login"] = "Informe o login.";	  
    
    if (empty($senha))
        $erro["senha"] = "Informe a senha.";    

	if (isset($erro) === false)
	{
		$conexao = getConexao();
		$stm = $conexao->prepare("SELECT id FROM usuarios WHERE login = ? AND senha = ?");
		$stm->bind_param("ss", $login, $senha);
		$stm->execute();

		$rs = (array)$stm->get_result()->fetch_assoc();		
		$stm->close();
		$conexao->close();

		/**
		 * Retorna um número informando a quantidade de registros encontrados  
		 */
		if (count($rs))
		{			
			$_SESSION["usuario"] = $rs["id"];
			header("location:/"); 
		}			
		else			
			$erro["auth"] = "Usuario ou senha inválidos";		
	}      
    
}

?>

<div class="container">

	<div class="row">

    	<div class="offset-lg-4 col-lg-4">
			<h2 class="text-center">Login no Site</h2>	

			<?php

				if (isset($erro["auth"])){					
					echo '<div class="alert mt-5 alert-warning alert-dismissible fade show" role="alert">'.
						$erro["auth"].
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
						'<span aria-hidden="true">&times;</span>'.
					'</button>'.
					'</div>';
				}
				
			?>	

			<form class="mt-4" method="post">
		
			<div class="form-group">
				<label for="login">Login</label>
				<input class="form-control col-lg-12<?php echo isset($erro["login"]) ? " is-invalid" : null;?>" type="text" maxlength="10" id="login" name="login" value="<?php echo $login ?? null;?>">
				<div class="invalid-feedback"><?php echo $erro["login"] ?? "";?></div>
			</div>

			<div class="form-group">
				<label for="senha">Senha</label>
				<input class="form-control col-lg-12<?php echo isset($erro["senha"]) ? " is-invalid" : null;?>" type="password" maxlength="60" id="senha" name="senha" value="<?php echo $senha ?? null;?>">
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