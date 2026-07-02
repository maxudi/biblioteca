<?php

// Informações para conectar ao banco de dados via variáveis de ambiente
$servidor = getenv('DB_HOST') ?: 'localhost';
$usuario = getenv('DB_USER') ?: 'root';
$senha = getenv('DB_PASS') ?: '';
$banco = getenv('DB_NAME') ?: 'biblioteca';

// Cria a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);

// Verifica se a conexão falhou
if (!$conexao) {
    die('Falha na conexão: ' . mysqli_connect_error());
}

// Define o conjunto de caracteres para UTF-8 para evitar problemas com acentuação
mysqli_set_charset($conexao, 'utf8mb4');

?>