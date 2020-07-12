<?php

require_once "../classes.php";
require_once "../auth.php";


/**
 * Abre a conexao com o banco de dados
 */
$pdo = Database::getInstance();

/**
 * Recupera os dados do usuário baseado no id armazenado na $_SESSION
 */
$stm = $pdo->query("SELECT nome, email FROM usuarios WHERE id =".$_SESSION["usuario"]["id"]);
$rs = $stm->fetch(\PDO::FETCH_ASSOC);

$nome = $rs["nome"];
$email = $rs["email"];


if (count($_POST)){

	$nome = trim($_POST["nome"] ?? null);
	$nome = $nome ?: null;

	$email = trim($_POST["email"] ?? null);
	$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;

	try {
		
		$stm = $pdo->prepare("UPDATE usuarios SET nome=:nome, email=:email WHERE id=:id");
		$stm->execute([
			":id" => $_SESSION["usuario"]["id"],
			":nome" => $nome,
			":email" => $email
		]);

		/**
		 * Altera o nome do usuário na SESSION para exibir o valor atualizado na barra de menu 
		 */
		$_SESSION["usuario"]["nome"] = $nome;

		$updated = true;

	} catch (\PDOException $e){		

		/**
		 * Código de erro para valores NOT NULL
		 */
		if ($e->errorInfo[1] == 1048){

			if (strstr($e->errorInfo[2],"'nome'"))
				$erro["nome"] = "Informe o seu nome";

			if (strstr($e->errorInfo[2],"'email'"))
				$erro["email"] = "Escolha um email válido";
		}

		/**
		 * Código de erro para registros UNIQUE
		 */
		if ($e->errorInfo[1] == 1062){

			if (strstr($e->errorInfo[2],"'usuarios.email'"))
				$erro["email"] = "Email já existe";
		}

			
	}

}

/**
 * Recuperar o conteúdo do HTML neste ponto para que possa exibir o valor atribuído à $_SESSION["usuario"]["nome"]
 */
require_once "../html_header.php";

?>


<div class="container">

<div class="row">

    <div class="offset-lg-4 col-lg-4">

		<h2 class="titulo-pagina">Atualizar meus dados</h2>

		<?php echo isset($updated) ? Alert::getMessage("Atualizado com sucesso.","alert-success") : null; ?>

        <form class="mt-4" method="post">
    
        <div class="form-group">
            <label for="nome">Nome</label>
            <input class="form-control col-lg-12<?php echo isset($erro["nome"]) ? " is-invalid" : "";?>" type="text" maxlength="200" id="nome" name="nome" value="<?php echo $nome ?? "";?>">
            <div class="invalid-feedback"><?php echo $erro["nome"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control col-lg-12<?php echo isset($erro["email"]) ? " is-invalid" : "";?>" type="text" maxlength="20" id="email" name="email" value="<?php echo $email ?? "";?>">
            <div class="invalid-feedback"><?php echo $erro["email"] ?? "";?></div>
        </div>
    
        <div class="form-group">
            <button class="btn btn-success col-lg-12" type="submit" id="Atualizar dados">Atualizar dados</button>
        </div>

        </form>

    </div>

</div>

</div>
<?php
require_once "../html_footer.php";
?>
</body>
</html>