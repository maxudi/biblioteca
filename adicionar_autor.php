<?php
session_start();
require_once 'config/config_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($conexao, $_POST['nome'] ?? '');
    $pais = mysqli_real_escape_string($conexao, $_POST['pais'] ?? '');

    if (empty($nome)) {
        $_SESSION['mensagem_erro'] = 'O nome do autor é obrigatório.';
        header('Location: listar_autores.php');
        exit;
    }

    $sql = 'INSERT INTO autores (nome, pais) VALUES (?, ?)';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $nome, $pais);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensagem_sucesso'] = 'Autor adicionado com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao adicionar autor: ' . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: listar_autores.php');
exit;
?>