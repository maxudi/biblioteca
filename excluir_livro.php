<?php
session_start();
require_once 'config/config_bd.php';

if (isset($_GET['id'])) {
    $id_livro = mysqli_real_escape_string($conexao, $_GET['id']);
    $sql = 'DELETE FROM livros WHERE id_livro = ?';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_livro);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensagem_sucesso'] = 'Livro excluído com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao excluir livro.';
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: listar_livros.php');
exit;
?>