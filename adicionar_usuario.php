<?php
// Arquivo: adicionar_usuario.php

// Inicia a sessão para podermos usar mensagens de feedback (flash messages)
session_start();

require_once 'config/config_bd.php';

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Pega e sanitiza o nome do usuário
    // A função mysqli_real_escape_string ajuda a prevenir SQL Injection
    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);

    // Validação básica
    if (empty($nome)) {
        $_SESSION['mensagem_erro'] = "O campo nome é obrigatório.";
        header("Location: listar_usuarios.php");
        exit();
    }

    $foto_nome_final = null;

    // 2. Processa o upload da foto (se enviada)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $diretorio_upload = 'uploads/';
        
        // Garante que o diretório 'uploads' existe
        if (!is_dir($diretorio_upload)) {
            mkdir($diretorio_upload, 0755, true);
        }

        // Gera um nome de arquivo único para evitar sobreposições
        $foto_nome_final = uniqid() . '_' . basename($_FILES["foto"]["name"]);
        $caminho_arquivo = $diretorio_upload . $foto_nome_final;

        // Move o arquivo temporário para o diretório final
        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_arquivo)) {
            $_SESSION['mensagem_erro'] = "Houve um erro ao fazer o upload da foto.";
            header("Location: listar_usuarios.php");
            exit();
        }
    }

    // 3. Insere os dados no banco de dados usando Prepared Statements (mais seguro)
    $sql = "INSERT INTO usuarios (nome, foto) VALUES (?, ?)";
    
    // Prepara a query
    $stmt = mysqli_prepare($conexao, $sql);

    if ($stmt) {
        // Associa os parâmetros ('s' para string)
        mysqli_stmt_bind_param($stmt, "ss", $nome, $foto_nome_final);

        // Executa a query
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['mensagem_sucesso'] = "Usuário adicionado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao adicionar usuário: " . mysqli_stmt_error($stmt);
        }

        // Fecha o statement
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['mensagem_erro'] = "Erro ao preparar a consulta: " . mysqli_error($conexao);
    }

    // Fecha a conexão
    mysqli_close($conexao);

    // Redireciona de volta para a lista de usuários
    header("Location: listar_usuarios.php");
    exit();

} else {
    // Se alguém tentar acessar o arquivo diretamente
    header("Location: listar_usuarios.php");
    exit();
}
?>