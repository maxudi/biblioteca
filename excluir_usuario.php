<?php
// Arquivo: excluir_usuario.php
require_once 'config/config_bd.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conexao, $_GET['id']);
    $upload_dir = 'uploads/';

    // 1. Busca o nome do arquivo da foto antes de deletar o registro
    $sql_select = "SELECT foto FROM usuarios WHERE id_usuarios = ?";
    $stmt_select = mysqli_prepare($conexao, $sql_select);
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $resultado = mysqli_stmt_get_result($stmt_select);
    $usuario = mysqli_fetch_assoc($resultado);
    
    // 2. Apaga o arquivo da foto do servidor, se existir
    if ($usuario && !empty($usuario['foto']) && file_exists($upload_dir . $usuario['foto'])) {
        unlink($upload_dir . $usuario['foto']);
    }
    mysqli_stmt_close($stmt_select);

    // 3. Deleta o registro do banco de dados
    $sql_delete = "DELETE FROM usuarios WHERE id_usuarios = ?";
    $stmt_delete = mysqli_prepare($conexao, $sql_delete);
    mysqli_stmt_bind_param($stmt_delete, "i", $id);
    mysqli_stmt_execute($stmt_delete);
    mysqli_stmt_close($stmt_delete);
}

// Redireciona de volta para a lista
header("Location: listar_usuarios.php");
mysqli_close($conexao);
exit();
?>