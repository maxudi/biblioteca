<?php
// Arquivo: listar_usuarios.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
        h1 { color: #333; }
    </style>
</head>
<body>

    <h1>Lista de Usuários Cadastrados</h1>

    <?php
    // 1. Inclui o arquivo de conexão que está dentro da pasta 'config'
    require_once 'config/config_bd.php';

    // 2. Prepara a consulta SQL para selecionar os dados dos usuários
    //    IMPORTANTE: Substitua 'usuarios' pelo nome real da sua tabela de usuários.
    $sql = "SELECT id_usuarios, nome, senha FROM usuarios ORDER BY nome ASC";

    // 3. Executa a consulta no banco de dados
    $resultado = mysqli_query($conexao, $sql);

    // 4. Verifica se a consulta retornou algum resultado
    if (mysqli_num_rows($resultado) > 0) {
        // Inicia a tabela HTML
        echo "<table>";
        echo "<tr><th>ID</th><th>Nome</th><th>Email</th></tr>";

        // 5. Loop para exibir cada usuário encontrado
        while ($usuario = mysqli_fetch_assoc($resultado)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($usuario['id_usuarios']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($usuario['senha']) . "</td>";
            echo "</tr>";
        }

        // Fecha a tabela HTML
        echo "</table>";

    } else {
        // Se não houver usuários, exibe uma mensagem
        echo "<p>Nenhum usuário encontrado no banco de dados.</p>";
    }

    // 6. Fecha a conexão com o banco de dados
    mysqli_close($conexao);
    ?>

</body>
</html>