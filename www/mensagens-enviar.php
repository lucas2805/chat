<?php

require_once "../classes.php";
require_once "../auth.php";

$headers = apache_request_headers();	
$mensagem = substr(trim($_POST["mensagem"] ?? null), 0, 255);
$token = (string)($_POST["token"] ?? null);

strlen($mensagem) ?: exit();

try {

	$pdo = Database::getInstance();

	$stm = $pdo->prepare("INSERT INTO mensagens (salas_id, usuarios_id, conteudo) values (:salas_id, :usuarios_id, :conteudo)");
	
	$stm->execute([
		":salas_id" => $_SESSION["usuario"]["sala_id"],
		":usuarios_id" => $_SESSION["usuario"]["id"],
		":conteudo" => $mensagem 
	]);

} catch (\PDOException $e){

	echo $e->getMessage();

}



echo $mensagem;