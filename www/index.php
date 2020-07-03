<?php
require_once "../html_header.php";
?>


<div class="container">
    
    <div class="row">

      <div class="col-lg-12">

        <h2 class="text-center">Home do Site</h2>

		 <?php echo "O ID do usuário logado é: {$_SESSION["usuario"]}";?>

      </div>

    </div>
</div>
 
      
<?php

require_once "../html_footer.php";