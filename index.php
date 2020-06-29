<?php

/*
0 === false;
1 === true;

// Verifica se uma variável foi definida ou não
isset();
*/

if ( isset($_POST["enviar"]) ) {

    $matricula = $_POST["matricula"] ?? 0;
    $senha = $_POST["senha"] ?? "";

    /**
     * Matrícula não pode ser vazio
     * Senha não poder vazio
     */

    if (strlen($matricula) === 0){
        $erro["matricula"] = "Digite sua matrícula.";
    } 
    
    if (strlen($senha) === 0){
        $erro["senha"] = "Digite sua senha.";
    }

    if (isset($erro) === false){
        echo "<h4>Verifica se existe no banco.</h4>";
    }
}

?>

<!DOCTYPE html>


<head>
  <meta charset="UTF-8" />
  <title>Formulário de Login e Registro com HTML5 e CSS3</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <div class="container" >
    <a class="links" id="paracadastro"></a>
    <a class="links" id="paralogin"></a>
     
    <div class="content">      
      <!--FORMULÁRIO DE LOGIN-->
      <div id="login">
        <form method="post" action="">
            <h1>Login</h1>

            <p>
                Matrícula: <input type="text" maxlength="6" name="matricula" value=""><br>
                <span style="color:red;"><?php echo $erro["matricula"] ?? "";?></span>
            </p>
            <p>
                Senha: <input type="password" maxlength="6" name="senha" value=""><br>
                <span style="color:red;"><?php echo $erro["senha"] ?? "";?></span>
            </p>
            <p>
                <input type="submit" id="btn_enviar" name="enviar" value="Logar">
            </p>
           
          <p class="link">
            Ainda não tem conta?
            <a href="#paracadastro">Cadastre-se</a>
          </p>
        </form>
      </div>
 
      
</body>
</html>