<?php

require_once "../html_header_public.php";

/**
 * Se a sessão do usuário foi iniciada (ele está logado)
 * Redireciona para a página "index.php"
 */
if ( isset($_SESSION["usuario"]) )
	header("location:/");


if ( count($_POST) ) {

	$login = trim($_POST["login"] ?? null);
	$nome = trim($_POST["nome"] ?? null);
	$email = trim($_POST["email"] ?? null);
	$senha = trim($_POST["senha"] ?? null);
	$senha_confirmacao = trim($_POST["senha_confirmacao"] ?? null);

    ($login) ?: $erro["login"] = "Campo obrigatório";		
	($nome) ?: $erro["nome"] = "Campo obrigatório"; 
	filter_var($email, FILTER_VALIDATE_EMAIL) ?: $erro["email"] = "Informe um email válido";
    ($senha) ?: $erro["senha"] = "Campo obrigatório";
	($senha_confirmacao) ?: $erro["senha_confirmacao"] = "Campo obrigatório";
	
	if ( ($senha && $senha_confirmacao) && ($senha !== $senha_confirmacao) )
		$erro["senha"] = $erro["senha_confirmacao"] = "Valores não podem ser diferentes";
	
	if (!isset($erro)){

		try {

			/**
			 * Cria (abre) uma conexão com o banco de dados
			 */
			$pdo = Database::getInstance();

			/**
			 * Declara um consulta preparada para evitar SQLinjection
			 */	
			$stm = $pdo->prepare("INSERT INTO usuarios (login, nome, senha, email) values (:login, :nome, :senha, :email)");

			$stm->execute([
				":login" => strtolower($login),
				":nome" => $nome,
				":senha" => password_hash($senha, PASSWORD_DEFAULT),
				":email" => $email
				]);	

			/**
			 * Retorna o último ID inserido no banco e atribui à $_SESSION
			 * Depois redireciona para a index.php já autenticado
			 */
			$_SESSION["usuario"] = $pdo->lastInsertId();

			header("location:/");

		} catch (\PDOException $e){

			if ($e->errorInfo[1] == 1062){

				if (strstr($e->errorInfo[2],"usuarios.login"))
					$erro["login"] = "Já existe no banco de dados";

				if (strstr($e->errorInfo[2],"usuarios.email"))
					$erro["email"] = "Já existe no banco de dados";
			}

		}

	} 
    
}


?>
<div class="container">

        <h2 class="text-center">Cadastro no site</h2>	

		<form class="mt-4" method="post" autocomplete="off">

		<div class="row">

			<div class="offset-lg-3 col-lg-6">

				<div class="form-row">
					<div class="form-group col-lg-12">
						<label for="nome">Nome completo</label>
						<input class="form-control<?php echo isset($erro["nome"]) ? " is-invalid" : "";?>" type="text" maxlength="255" id="nome" name="nome" value="<?php echo $nome ?? "";?>">
						<div class="invalid-feedback"><?php echo $erro["nome"] ?? "";?></div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-lg-4">
						<label for="nome">Login</label>
						<input class="form-control<?php echo isset($erro["login"]) ? " is-invalid" : "";?>" type="text" maxlength="50" id="login" name="login" value="<?php echo $login ?? "";?>">
						<div class="invalid-feedback"><?php echo $erro["login"] ?? "";?></div>
					</div>
					<div class="form-group col-lg-8">
						<label for="email">Email</label>
						<input class="form-control<?php echo isset($erro["email"]) ? " is-invalid" : "";?>" type="text" maxlength="50" id="email" name="email" value="<?php echo $email ?? "";?>">
						<div class="invalid-feedback"><?php echo $erro["email"] ?? "";?></div>
					</div>
				</div>				

				<div class="form-row">
					<div class="form-group col-lg-6">
						<label for="senha">Senha</label>
						<input class="form-control<?php echo isset($erro["senha"]) ? " is-invalid" : "";?>" type="password" maxlength="6" id="senha" name="senha" value="<?php echo $senha ?? "";?>">
						<div class="invalid-feedback"><?php echo $erro["senha"] ?? "";?></div>
					</div>
					<div class="form-group col-lg-6">
						<label for="senha_confirmacao">Repita a senha</label>
						<input class="form-control<?php echo isset($erro["senha_confirmacao"]) ? " is-invalid" : "";?>" type="password" maxlength="6" id="senha_confirmacao" name="senha_confirmacao" value="<?php echo $senha_confirmacao ?? "";?>">
						<div class="invalid-feedback"><?php echo $erro["senha_confirmacao"] ?? "";?></div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-lg-12">
						<button class="btn btn-success btn-block" type="submit" id="btn_cadastrar">Cadastrar</button>
					</div>
				</div>
			
			</div>	

		</div>

        </form>
 
</div>
<?php 
require_once "../html_footer.php";