<?php

if (!isset($_SESSION["usuario"]) && $_SERVER["SCRIPT_NAME"] !== "/login.php" && $_SERVER["SCRIPT_NAME"] !== "/user-add.php")
	header("location:/login.php");