<?php

$script = $_SERVER["SCRIPT_NAME"];

if (!isset($_SESSION["usuario"]) && $_SERVER["SCRIPT_NAME"] !== "/login.php" && $_SERVER["SCRIPT_NAME"] !== "/user-add.php")
	header("location:/login.php");

if (
	$script !== "/mensagens-enviar.php" 
	&& 
	$script !== "/mensagens-recuperar.php" 
	&& 
	$script !== "/sala.php"
	&& 
	$script !== "/usuarios-status.php")
{
	$pdo = Database::getInstance();
	$stm = $pdo->query("DELETE FROM usuarios_status WHERE usuarios_id = {$_SESSION["usuario"]["id"]} AND session_id =\"".session_id()."\"");
	$stm->execute();
}
	

