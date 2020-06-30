<?php

// Habilita o uso da variável Global $_SESSION
session_start();


// Se estiver logado a variável vai existir e o usuário será redirecionado imediatamente para a index.php
if ( isset($_SESSION["user"]) )
  header("location:index.php");

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

<!DOCTYPE html>
<head>
  <meta charset="UTF-8" />
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
<div class="container">
    
    <div class="row">

      <div class="offset-lg-4 col-lg-4">

        <h2 class="mt-5">Formulário de login</h2>

        <form class="mt-5" method="post">
      
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
            <button class="btn btn-success col-lg-12" type="submit" id="Logar no sistema">Logar no sistema</button>
          </div>              
            
          <p class="link">
            Ainda não tem conta? <a href="#paracadastro">Cadastre-se</a>
          </p>

        </form>

      </div>

    </div>
</div>
 
      
</body>
</html>