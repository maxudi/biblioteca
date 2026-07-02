<?php
session_start();
require_once 'config/config_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo'] ?? '');
    $autor_id = !empty($_POST['autor_id']) ? mysqli_real_escape_string($conexao, $_POST['autor_id']) : null;
    $ano = !empty($_POST['ano']) ? mysqli_real_escape_string($conexao, $_POST['ano']) : null;
    $status = mysqli_real_escape_string($conexao, $_POST['status'] ?? 'disponivel');

    if (empty($titulo)) {
        $_SESSION['mensagem_erro'] = 'O título do livro é obrigatório.';
        header('Location: listar_livros.php');
        exit;
    }

    $sql = 'INSERT INTO livros (titulo, autor_id, ano, status) VALUES (?, ?, ?, ?)';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'siss', $titulo, $autor_id, $ano, $status);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensagem_sucesso'] = 'Livro adicionado com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao adicionar livro: ' . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: listar_livros.php');
exit;
?>