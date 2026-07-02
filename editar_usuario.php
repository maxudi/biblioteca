<?php
// Arquivo: editar_usuario.php
require_once 'config/config_bd.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $id = mysqli_real_escape_string($conexao, $_POST['id_usuario']);
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $nome_foto_atual = null;

    // --- LÓGICA DE UPLOAD DA FOTO ---
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $upload_dir = 'uploads/';
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        $nome_foto_nova = uniqid() . '.' . $extensao;
        $caminho_foto_nova = $upload_dir . $nome_foto_nova;

        // Validações (exemplo: tipo e tamanho)
        $tipos_permitidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($extensao, $tipos_permitidos) && $_FILES['foto']['size'] <= 2000000) { // Max 2MB
            // Antes de mover a nova foto, apaga a antiga se ela existir
            $sql_foto_antiga = "SELECT foto FROM usuarios WHERE id_usuarios = ?";
            $stmt_foto = mysqli_prepare($conexao, $sql_foto_antiga);
            mysqli_stmt_bind_param($stmt_foto, "i", $id);
            mysqli_stmt_execute($stmt_foto);
            $resultado_foto = mysqli_stmt_get_result($stmt_foto);
            $usuario_antigo = mysqli_fetch_assoc($resultado_foto);

            if (!empty($usuario_antigo['foto']) && file_exists($upload_dir . $usuario_antigo['foto'])) {
                unlink($upload_dir . $usuario_antigo['foto']); // Apaga o arquivo antigo do servidor
            }
            mysqli_stmt_close($stmt_foto);

            // Move o novo arquivo
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto_nova)) {
                $nome_foto_atual = $nome_foto_nova;
            }
        }
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    // Prepara a consulta SQL
    if ($nome_foto_atual !== null) {
        // Se uma nova foto foi enviada, atualiza o nome e a foto
        $sql = "UPDATE usuarios SET nome = ?, foto = ? WHERE id_usuarios = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $nome, $nome_foto_atual, $id);
    } else {
        // Se nenhuma foto foi enviada, atualiza apenas o nome
        $sql = "UPDATE usuarios SET nome = ? WHERE id_usuarios = ?";
        $stmt = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($stmt, "si", $nome, $id);
    }

    // Executa e redireciona
    if (mysqli_stmt_execute($stmt)) {
        header("Location: listar_usuarios.php?status=success");
    } else {
        header("Location: listar_usuarios.php?status=error");
    }
    mysqli_stmt_close($stmt);

} else {
    header("Location: listar_usuarios.php");
}

mysqli_close($conexao);
exit();
?>