<?php
session_start();
require_once 'config/config_bd.php';

if (isset($_GET['id'])) {
    $id_emprestimo = mysqli_real_escape_string($conexao, $_GET['id']);

    $sql = 'UPDATE emprestimos SET status = ? WHERE id_emprestimo = ?';
    $stmt = mysqli_prepare($conexao, $sql);
    $status = 'devolvido';
    mysqli_stmt_bind_param($stmt, 'si', $status, $id_emprestimo);
    if (mysqli_stmt_execute($stmt)) {
        $sqlSelect = 'SELECT livro_id FROM emprestimos WHERE id_emprestimo = ?';
        $stmtSelect = mysqli_prepare($conexao, $sqlSelect);
        mysqli_stmt_bind_param($stmtSelect, 'i', $id_emprestimo);
        mysqli_stmt_execute($stmtSelect);
        $result = mysqli_stmt_get_result($stmtSelect);
        $emprestimo = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmtSelect);

        if ($emprestimo) {
            $sqlUpdate = 'UPDATE livros SET status = ? WHERE id_livro = ?';
            $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);
            $disponivel = 'disponivel';
            mysqli_stmt_bind_param($stmtUpdate, 'si', $disponivel, $emprestimo['livro_id']);
            mysqli_stmt_execute($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);
        }

        $_SESSION['mensagem_sucesso'] = 'Livro devolvido com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao registrar devolução.';
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: emprestimos.php');
exit;
?>