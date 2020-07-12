<?php

require_once "../classes.php";
require_once "../auth.php";

$mensagem_id = (int)($_GET["id_ultima_mensagem"] ?? null);
$sala_id = (int)$_GET["sala_id"];


isset($sala_id) ?: exit();

$pdo = Database::getInstance();

$sql = "SELECT a.id, a.salas_id, a.usuarios_id, a.conteudo, a.created_at,
		b.login as login
		FROM mensagens a 
		LEFT JOIN usuarios b ON b.id = a.usuarios_id WHERE a.salas_id = {$sala_id}";


/**
 * Se o ID não for informado, carrega as últimas 10 mensagens
 */
if (!$mensagem_id) {

	//$sql .= " ORDER BY a.id DESC LIMIT 10;";

	$stm = $pdo->query($sql);
	$stm->execute();
	
	//$rs = array_reverse((array)$stm->fetchAll(\PDO::FETCH_ASSOC));

	$rs = $stm->fetchAll(\PDO::FETCH_ASSOC);

} else {

	$sql .= " AND a.id > {$mensagem_id} LIMIT 10;";
	$stm = $pdo->query($sql);
	$stm->execute();
	$rs = (array)$stm->fetchAll(\PDO::FETCH_ASSOC);
}

header("Content-type: application/json");
echo json_encode($rs);