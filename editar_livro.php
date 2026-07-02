<?php
session_start();
require_once 'config/config_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = mysqli_real_escape_string($conexao, $_POST['id_livro']);
    $titulo = mysqli_real_escape_string($conexao, $_POST['titulo'] ?? '');
    $ano = !empty($_POST['ano']) ? mysqli_real_escape_string($conexao, $_POST['ano']) : null;
    $status = mysqli_real_escape_string($conexao, $_POST['status'] ?? 'disponivel');

    if (empty($titulo)) {
        $_SESSION['mensagem_erro'] = 'O título do livro é obrigatório.';
        header('Location: listar_livros.php');
        exit;
    }

    $sql = 'UPDATE livros SET titulo = ?, ano = ?, status = ? WHERE id_livro = ?';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'sisi', $titulo, $ano, $status, $id_livro);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensagem_sucesso'] = 'Livro atualizado com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao atualizar livro: ' . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: listar_livros.php');
exit;
?>