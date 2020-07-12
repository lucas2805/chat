<?php

if (!isset($_SESSION["usuario"]) && $_SERVER["SCRIPT_NAME"] !== "/login.php" && $_SERVER["SCRIPT_NAME"] !== "/user-add.php")
	header("location:/login.php");

if ($_SERVER["SCRIPT_NAME"] !== "/mensagens-enviar.php" && $_SERVER["SCRIPT_NAME"] !== "/mensagens-recuperar.php")
	unset($_SESSION["usuario"]["sala_id"]);