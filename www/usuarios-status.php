<?php

require_once "../classes.php";
require_once "../auth.php";

$pdo = Database::getInstance();
$salas_id = (int)($_GET["salas_id"] ?? null);

/**
 * Atualizo o campo updated_at para o registro do usuário atual
 */
$stm = $pdo->query("UPDATE usuarios_status SET updated_at=\"".date("Y-m-d H:i:s")."\" 
		WHERE usuarios_id=".$_SESSION["usuario"]["id"]." AND `session_id`=\"".session_id()."\"");

$stm->execute();

/**
 * Exclui o registro dos usuários que não atualizaram
 * o campo updated_at nos últimos 5 segundos
 */
$stm = $pdo->query(
	"DELETE FROM usuarios_status 
	WHERE TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP(), updated_at)) > 5;"
	);

$stm->execute();

/**
 * Recuperando os usuários online
 * que fizeram o update na tabela nos últimos 5 segundos
 */
$stm = $pdo->query(
	"SELECT a.usuarios_id, a.salas_id, b.login 
	FROM usuarios_status a LEFT JOIN usuarios b
	ON b.id = a.usuarios_id 
	WHERE salas_id = {$salas_id} GROUP BY `login` ORDER BY b.login ASC;"
	);

$stm->execute();

$rs = $stm->fetchAll(\PDO::FETCH_OBJ);

header("Content-type: application/json;charset=utf8");
echo json_encode($rs);