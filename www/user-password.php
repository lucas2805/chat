<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

if (count($_POST)){

	$senha_atual = trim($_POST["senha_atual"] ?? null);
	$nova_senha = trim($_POST["nova_senha"] ?? null);
	$confirma_senha = trim($_POST["confirma_senha"] ?? null);

	($senha_atual) ?: $erro["senha_atual"] = "Senha atual é obrigatória";
	($nova_senha) ?: $erro["nova_senha"] = "Nova senha não poder ser vazia";
	($confirma_senha) ?: $erro["confirma$confirma_senha"] = "Confirmação da senha não poder ser vazia";
	($nova_senha === $confirma_senha) ?: $erro["nova_senha"] = "Valores não correspondem";

	if (!isset($erro)){

		$pdo = Database::getInstance();
		$stm = $pdo->query("SELECT senha FROM usuarios WHERE id = ".$_SESSION["usuario"]["id"]);
		$rs = $stm->fetch(\PDO::FETCH_ASSOC);

		if (password_verify($senha_atual, $rs["senha"])){
			
			$stm = $pdo->prepare("UPDATE usuarios SET senha=:senha WHERE id=:id");
			
			$stm->execute([
				":id" => $_SESSION["usuario"]["id"],
				":senha" => password_hash($nova_senha, PASSWORD_DEFAULT)
			]);	

			$updated = true;

		} else {

			$erro["senha_atual"] = "Senha antiga é incorreta";
		}

	}

}

?>

<h2 class="text-center">Alterar Senha</h2>
<div class="container">

<div class="row">

    <div class="offset-lg-4 col-lg-4">

		<?php echo isset($updated) ? Alert::getMessage("Atualizado com sucesso.","alert-success") : null; ?>

        <form class="mt-4" method="post" autocomplete="off">
    
		<div class="form-group">
            <label for="nome">Senha atual</label>
            <input class="form-control col-lg-12<?php echo isset($erro["senha_atual"]) ? " is-invalid" : "";?>" type="password" name="senha_atual" value="<?php echo $senha_atual ?? "";?>">
            <div class="invalid-feedback"><?php echo $erro["senha_atual"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="nome">Nova senha</label>
            <input class="form-control col-lg-12<?php echo isset($erro["nova_senha"]) ? " is-invalid" : "";?>" type="password" name="nova_senha" value="<?php echo $nova_senha ?? "";?>">
            <div class="invalid-feedback"><?php echo $erro["nova_senha"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="email">Confirma nova senha</label>
            <input class="form-control col-lg-12<?php echo isset($erro["nova_senha"]) ? " is-invalid" : "";?>" type="password" name="confirma_senha" value="<?php echo $confirma_senha ?? "";?>">
            <div class="invalid-feedback"><?php echo $erro["nova_senha"] ?? "";?></div>
        </div>
    
        <div class="form-group">
            <button class="btn btn-success col-lg-12" type="submit" id="Atualizar dados">Salvar</button>
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