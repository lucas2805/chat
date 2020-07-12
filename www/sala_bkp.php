<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";

unset($_SESSION["salas_id"]);

/**
 * Recupero o ID da sala enviado via POST e faço o CAST
 */
$sala_id = (int)($_POST["id"] ?? null);

/**
 * Abre a conexão com o banco
 */
$pdo = Database::getInstance();

/**
 * Recupera os dados da sala (disciplina e tema)
 */
$stm = $pdo->query("SELECT a.id sala_id, a.usuarios_id, a.tema, b.nome
		FROM salas a LEFT JOIN disciplinas b ON b.id = a.disciplinas_id 
		WHERE a.id = " . $sala_id
	);

/**
 * Verifica se a quantidade de registros 
 * é maior que zero na consulta de salas
 */
if ($stm->rowCount())
{
	$rs_sala = $stm->fetch(\PDO::FETCH_OBJ);

	$_SESSION["usuario"]["sala_id"] = $rs_sala->sala_id;

	/**
	 * Recuperar as 5 últimas mensagens do banco de dados
	 */
	$stm = $pdo->query("SELECT mensagens.id as id, mensagens.salas_id, mensagens.usuarios_id AS remetente_id, 
	mensagens.conteudo FROM mensagens LEFT JOIN usuarios ON usuarios.id = mensagens.usuarios_id
	WHERE mensagens.salas_id = " . $sala_id);

	$rs_mensagens = $stm->fetchAll(\PDO::FETCH_ASSOC);

} else {
	
	/**
	 * Se não encontrou o ID da sala no banco exibe a mensagem abaixo
	 * e encerra o script
	 */
	echo "<div class=\"container\">
			<div class=\"row\">
				<div class=\"col-lg-12 text-center\">
					<h4 class=\"titulo-pagina text-danger\">OPS! Sala não encontrada</h4>
					Escolha outras disponíveis, <a href=\"/sala-consulta.php\">clique aqui.</a>
				</div>					
			</div>
		</div>";

		require_once "../html_footer.php";

		exit();
	}
?>







<div class="container">

	<div class="row">

		<div class="col-lg-4">
			<h4 class="font-weight-bold"><?php echo $rs_sala->nome;?></h5>
		</div>
		<div class="col-lg-8">
			<h5>Tema: <span class="text-secondary"><?php echo $rs_sala->tema;?></span></h5>			
		</div>		
	</div>

	<style>		
		#usuarios div {
			max-witdh: 30%;
		}	
	</style>

	<div class="bg-light" style="display:table; width: 100%; height:22rem; box-sizing:border-box; border-radius:.5rem;">

		<div id="usuarios" style="float:left; width: 30%; max-height:22rem; overflow-y:auto;">			
			<div class="pt-3 pl-3 pr-3 text-info">Usuário A</div>
		</div>		

		<div class="p-2" id="mensagem-container" style="float:left; width: 70%; max-height:22rem; overflow-y:auto;">

			<?php 
				foreach($rs_mensagens as $v){

					if ($v["remetente_id"] == $_SESSION["usuario"]["id"])
						$class = 'offset-lg-4 col-lg-8 bg-secondary text-light p-2 pl-3 rounded';
					else 
						$class = 'col-lg-8 bg-info text-light p-2 pl-3 rounded';

						echo "<div class='row m-2'>
									<div data-id='".$v["id"]."' class='".$class." mensagem-item'>
										{$v["conteudo"]}
									</div>
								</div>";									
				}
			?>

		</div>
	</div>

	<form id="frm_mensagens" method="POST">
		<div class="row mt-4">
			<div class="col-lg-8">
				<input class="form-control" type="text" name="mensagem" id="txt_mensagem" placeholder="Digite sua mensagem aqui...">
			</div>
			<div class="col-lg-2">
				<button type="submit" class="btn btn-success btn-block">Enviar</button>
			</div>
			<div class="col-lg-2">
				<a href="/sala-consulta.php" class="btn btn-danger btn-block">Sair da sala</a>
			</div>			
		</div>
	</form>

</div>




<script>


	$("#frm_mensagens").on("submit", function(e){		
		
		e.preventDefault();

		$.ajax({
			url: "/mensagens-enviar.php",
			method: "POST",
			headers: {
				"Authorization": "Bearer 012345678"
			},
			data:{
				mensagem: $("#txt_mensagem").val(),
				token: "token_enviar_mensagem"
			}

		}).done(function(data, textStatus, jqXHR){		

			$("#txt_mensagem").val("");
			$("#mensagem-container").animate({
				scrollTop: $("#mensagem-container").prop("scrollHeight")
			}, 600);
			
		});

	});


	function fn_ultima_mensagem()
	{
		const id = $(".mensagem-item").last().attr("data-id") ?? 0;

		$.ajax({

			url: "/mensagens-recuperar.php",
			method: "GET",
			headers: {
				"Authorization": "Bearer 012345678"
			},
			data:{
				id: id,
				token: "token_enviar_mensagem"
			}

		}).done(function(data){
			
			console.log("Mensagem recuperada: "+data, Math.random());

			setTimeout(fn_ultima_mensagem, 1000);

		});

		

	}

	//window.onload = fn_ultima_mensagem();


	//Scroll de página
	// $(".scroll").on("click", function(){
	// 	$("html, body").animate({
	// 		scrollTop: $(this.hash).offset().top}, 800);
	// 	});
	// });

	

	

</script>


<?php

require_once "../html_footer.php";