<?php

function getConexao(){

	$conexao = mysqli_connect("127.0.0.1", "root", "st0r@g&","chat");

	if (!$conexao)
		die("Erro ao conectar no banco: " . mysqli_connect_error());
	else
		return $conexao;
}
	