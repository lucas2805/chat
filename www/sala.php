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

	<div class="chat-container">
		<div class="chat-usuarios">
			<ul>
				<li>
					<h4 class="font-weight-bold">Participantes</h4>
					<hr>
				</li>
				<li>Segunda</li>
				<li>Terceita</li>
				<li>Quarta</li>
			</ul>
		</div>
		<div class="chat-mensagens">
			
		</div>
	</div>

	<div class="chat-formulario bg-light">
		<form id="frm_mensagens" autocomplete="off">
			<div class="form-row">
				<div class="col-lg-8 mt-3 mb-3">
				  <input type="text" id="txt_mensagem" class="form-control" placeholder="Digite sua mensagem aqui ...">
				</div>
				<div class="col-lg-2 col-6 mt-3 mb-3">
				  <button type="submit" id="btn-enviar" class="btn btn-success btn-block">Enviar</button>
				</div>
				<div class="col-lg-2 col-6 mt-3 mb-3">
					<button type="button" id="btn-sair" class="btn btn-danger btn-block">Sair</button>
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
		setTimeout(function(){

			$.ajax({

				url: "/mensagens-recuperar.php",
				method: "GET",
				data: {
					id: $(".mensagens").last().attr("data-id") ?? 0
				}

			}).done(function(data){

				if (data.length) {

					const chat_container = document.querySelector(".chat-mensagens");

					for (let i=0; i<data.length; i++){

						const div = document.createElement("div");
						
						div.setAttribute("data-id",data[i].id);
						div.classList.add("mensagens");

						if (data[i].usuarios_id == <?php echo $_SESSION["usuario"]["id"];?>)
							div.classList.add("minhas-mensagens");
						else
							div.classList.add("mensagens-outros-usuarios");

						div.innerHTML = "<span class=\"autor-mensagem\">"+ data[i].login +"</span>" + data[i].conteudo;			
						chat_container.append(div);				

					}

					$(".chat-mensagens").animate({
						scrollTop: $(".chat-mensagens").prop("scrollHeight")
					}, 800);

				}


				fn_ultima_mensagem();				

			});


		},1000);

	}

	window.onload = fn_ultima_mensagem();

</script>


<?php

require_once "../html_footer.php";