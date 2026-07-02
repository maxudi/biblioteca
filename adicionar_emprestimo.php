<?php
session_start();
require_once 'config/config_bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);
    $livro_id = mysqli_real_escape_string($conexao, $_POST['livro_id']);
    $data_emprestimo = mysqli_real_escape_string($conexao, $_POST['data_emprestimo']);
    $data_devolucao = mysqli_real_escape_string($conexao, $_POST['data_devolucao']);

    if (empty($usuario_id) || empty($livro_id) || empty($data_emprestimo) || empty($data_devolucao)) {
        $_SESSION['mensagem_erro'] = 'Preencha todos os campos do empréstimo.';
        header('Location: emprestimos.php');
        exit;
    }

    $sql = 'INSERT INTO emprestimos (usuario_id, livro_id, data_emprestimo, data_devolucao, status) VALUES (?, ?, ?, ?, ?)';
    $stmt = mysqli_prepare($conexao, $sql);
    $status = 'emprestado';
    mysqli_stmt_bind_param($stmt, 'iisss', $usuario_id, $livro_id, $data_emprestimo, $data_devolucao, $status);
    if (mysqli_stmt_execute($stmt)) {
        $sqlUpdate = 'UPDATE livros SET status = ? WHERE id_livro = ?';
        $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);
        $disponivel = 'emprestado';
        mysqli_stmt_bind_param($stmtUpdate, 'si', $disponivel, $livro_id);
        mysqli_stmt_execute($stmtUpdate);
        mysqli_stmt_close($stmtUpdate);
        $_SESSION['mensagem_sucesso'] = 'Empréstimo registrado com sucesso.';
    } else {
        $_SESSION['mensagem_erro'] = 'Erro ao registrar empréstimo: ' . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conexao);
header('Location: emprestimos.php');
exit;
?>