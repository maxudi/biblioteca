<?php
session_start();
require_once 'config/config_bd.php';

if (isset($_GET['id'])) {
    $id_autor = mysqli_real_escape_string($conexao, $_GET['id']);
    $sql = 'DELETE FROM autores WHERE id_autor = ?';
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id_autor);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['mensagem_sucesso'] = 'Autor excluído com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao excluir autor.';
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: listar_autores.php');
exit;
?>