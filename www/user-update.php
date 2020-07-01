
<?php
require_once "../html_header.php";

$endereco = $_POST ["endereco"] ?? null;
$email = $_POST ["email"] ?? null;
$git = $_POST ["git"] ?? null;

$endereco = trim($endereco);
$email = trim($email);
$git = trim($git);

if ( count($_POST) ) {

    if (!$endereco)
        $erro["endereco"] = "Endereço Inválido";     
    
    if (strlen($email) === 0 )
        $erro["email"] = "E-mail Inválido";   
        
        if (strlen($git) === 0 )
        $erro["git"] = "Git Hub Inválido"; 

    if (!isset($erro))
        echo "<h4>Dados alterados com sucesso.</h4>";
    
}
?>


<!DOCTYPE html>´

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios-atualizar</title>
</head>
<body>
    <h2 class="text-center">Atualizar dados</h2>
    <div class="container">

<div class="row">

    <div class="offset-lg-4 col-lg-4">
        	

        <form class="mt-4" method="post">
    
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input class="form-control col-lg-12<?php echo isset($erro["endereco"]) ? " is-invalid" : "";?>" type="text" maxlength="200" id="endereco" name="endereco" value="<?php echo $endereco?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["endereco"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="email">E-mail Alternativo</label>
            <input class="form-control col-lg-12<?php echo isset($erro["email"]) ? " is-invalid" : "";?>" type="text" maxlength="20" id="email" name="email" value="<?php echo $email ?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["email"] ?? "";?></div>
        </div>

        <div class="form-group">
            <label for="git">Git Hub</label>
            <input class="form-control col-lg-12<?php echo isset($erro["git"]) ? " is-invalid" : "";?>" type="text" maxlength="222" id="git" name="git" value="<?php echo $git ?? null;?>">
            <div class="invalid-feedback"><?php echo $erro["git"] ?? "";?></div>
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