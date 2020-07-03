<?php

function getConexao(){

	$conexao = mysqli_connect("127.0.0.1", "user", "123456","chat");

	if (!$conexao)
		die("Erro ao conectar no banco: " . mysqli_connect_error());
	else
		return $conexao;
}
	