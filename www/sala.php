<?php
require_once "../classes.php";
require_once "../auth.php";
require_once "../html_header.php";




/**
 * Recupero o ID da sala enviado via POST e faço o CAST
 */
$sala_id = (int)($_POST["id"] ?? null);

/**
 * Abre a conexão com o banco
 */
$pdo = Database::getInstance();

/**
 * Verifico se a sala existe
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
	
		$pdo = Database::getInstance();

		/**
		 * Atualiza o status do usuário na tabela de status para conectado
		 * pois acabou de entrar na sala
		 */

		$sql = "INSERT INTO usuarios_status (usuarios_id, salas_id, `session_id`)
			VALUES ({$_SESSION["usuario"]["id"]}, {$sala_id}, \"".session_id()."\") ON DUPLICATE KEY UPDATE 
			usuarios_id = {$_SESSION["usuario"]["id"]}, salas_id={$sala_id}, `session_id`=\"".session_id()."\", updated_at=\"".date('Y-m-d H:i:s')."\"";
		
		$pdo->query($sql);	


	$rs_sala = $stm->fetch(\PDO::FETCH_OBJ);

	/**
	 * Armazena o valor do ID na variável de sessão
	 * para controlar o valor da tabela de status do usuário
	 * e fornecer o valor como parâmetro quando necessário
	 */
	//$_SESSION["usuario"]["sala_id"] = $rs_sala->sala_id;

	/**
	 * Recuperar as 5 últimas mensagens do banco de dados
	 */
	$stm = $pdo->query("SELECT mensagens.id as id, mensagens.salas_id, mensagens.usuarios_id AS remetente_id, 
	mensagens.conteudo FROM mensagens LEFT JOIN usuarios ON usuarios.id = mensagens.usuarios_id
	WHERE mensagens.salas_id = " . $sala_id);

	$rs_mensagens = $stm->fetchAll(\PDO::FETCH_ASSOC);

} else {
	
	/**
	 * Se não encontrou o ID da sala no banco, 
	 * exibe a mensagem abaixo e encerra o script
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
		<h4 class="font-weight-bold mt-4">Participantes</h4>
			<ul id="participantes">
				
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
					<a href="/sala-consulta.php" class="btn btn-danger btn-block">Sair</a>
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
			data: {
				mensagem: $("#txt_mensagem").val(),
				sala_id: <?php echo $sala_id;?>
			}

		}).done(function(data, textStatus, jqXHR){		

			$("#txt_mensagem").val("");
			$("#mensagem-container").animate({
				scrollTop: $("#mensagem-container").prop("scrollHeight")
			}, 600);
			
		});

	});






	function fn_usuarios_status()
	{
		setTimeout(function(){ console.log(Math.random());

			$.ajax({

				url: "/usuarios-status.php",
				method: "GET",
				data: {
					salas_id: <?php echo $sala_id;?>
				}

			}).done(function(data){

				if (data.length > 0){

					$("#participantes").html("");

					for (let i=0; i<data.length; i++){

						const li = document.createElement("li");
						li.innerHTML = "<span style=\"margin-right:1rem;\">&#128578;</span>" + data[i].login;
						$("#participantes").append(li);
					}

				}

				fn_usuarios_status();

			});

		}, 1000);

		
	}

	fn_usuarios_status();




	function fn_ultima_mensagem()
	{
		setTimeout(function(){

			$.ajax({

				url: "/mensagens-recuperar.php",
				method: "GET",
				data: {
					id_ultima_mensagem: $(".mensagens").last().attr("data-id") ?? 0,
					sala_id: <?php echo $sala_id;?>
				}

			}).done(function(data){

				if (data.length > 0) {

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


		},800);

	}

	window.onload = fn_ultima_mensagem();

</script>


<?php

require_once "../html_footer.php";