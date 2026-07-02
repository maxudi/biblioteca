<?php

// Informações para conectar ao banco de dados
$servidor = "localhost";    // O servidor do banco de dados, geralmente 'localhost'
$usuario = "biblioteca";     // Seu nome de usuário do banco de dados
$senha = "12345678";       // Sua senha do banco de dados
$banco = "biblioteca";     // O nome do banco de dados

// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se a conexão falhou
if (!$conexao) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Opcional: Define o conjunto de caracteres para UTF-8 para evitar problemas com acentuação
mysqli_set_charset($conexao, "utf8");

?>