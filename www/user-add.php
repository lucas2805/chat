
<?php
require_once "../html_header.php";
if ( isset($_SESSION["user"]) )
  header("location:/login.php");

  $nome = $_POST ["nome"] ?? null;
  $email = $_POST ["email"] ?? null;
  $senha = $_POST ["senha"] ?? null;

 $nome = trim($nome);
 $email = trim($email);
$senha = trim($senha);

if ( count($_POST) ) {

    if (!$nome)
        $erro["nome"] = "Obrigatório valor numérico maior que zero";     
    
    if (strlen($email) === 0 )
        $erro["email"] = "E-mail Inválido";   
        
        if (strlen($senha) === 0 )
        $erro["senha"] = "Comprimento de senha inválido"; 

    if (!isset($erro))
        echo "<h4>Usúario cadastrado com sucesso.</h4>";
    
}




?>
<div class="container">

<div class="row">

    <div class="offset-lg-4 col-lg-4">
        <h2 class="text-center">Cadastro no site</h2>		

        <form class="mt-4" method="post">
    
        <div class="form-group">
            <label for="nome">Nome</label>
            <input class="form-control col-lg-12<?php echo isset($erro["nome"]) ? " is-invalid" : "";?>" type="text" maxlength="6" id="nome" name="nome" value="<?php echo $nome?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["nome"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="email">E-mail</label>
            <input class="form-control col-lg-12<?php echo isset($erro["email"]) ? " is-invalid" : "";?>" type="text" maxlength="20" id="email" name="email" value="<?php echo $email ?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["email"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="senha">Senha</label>
            <input class="form-control col-lg-12<?php echo isset($erro["senha"]) ? " is-invalid" : "";?>" type="password" maxlength="6" id="senha" name="senha" value="<?php echo $senha ?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["senha"] ?? "";?></div>
        </div>
    
        <div class="form-group">
            <button class="btn btn-success col-lg-12" type="submit" id="Cadastrar no Sistema">Cadastre-se</button>
        </div>

        </form>

    </div>

</div>

</div>
<?php
require_once "../html_footer.php";

