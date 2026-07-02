<?php
session_start();
require_once 'config/config_bd.php';
require_once 'includes/header.php';
renderHeader('Alunos - Biblioteca E.E. Bueno Brandão');
?>

<div class="page-header p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div>
            <h1 class="h2 fw-bold mb-2">Alunos cadastrados</h1>
            <p class="text-muted mb-0">Gerencie os alunos da Biblioteca Escolar Bueno Brandão.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Cadastrar aluno
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Voltar ao início</a>
        </div>
    </div>
</div>

<?php
if (isset($_SESSION['mensagem_sucesso'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo $_SESSION['mensagem_sucesso'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['mensagem_sucesso']);
}

if (isset($_SESSION['mensagem_erro'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo $_SESSION['mensagem_erro'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
    unset($_SESSION['mensagem_erro']);
}
?>

<div class="table-responsive mb-5">
    <table class="table table-striped table-hover align-middle rounded-4 overflow-hidden shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Foto</th>
                <th>ID</th>
                <th>Nome</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id_usuarios, nome, foto FROM usuarios ORDER BY nome ASC";
            $resultado = mysqli_query($conexao, $sql);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($usuario = mysqli_fetch_assoc($resultado)) {
                    $foto_caminho = 'https://placehold.co/50x50/EFEFEF/AAAAAA&text=...';
                    if (!empty($usuario['foto']) && file_exists('uploads/' . $usuario['foto'])) {
                        $foto_caminho = 'uploads/' . $usuario['foto'];
                    }
            ?>
            <tr>
                <td>
                    <img src="<?= htmlspecialchars($foto_caminho) ?>" alt="Foto de <?= htmlspecialchars($usuario['nome']) ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                </td>
                <td><?= htmlspecialchars($usuario['id_usuarios']) ?></td>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td class="text-center">
                    <button class="btn btn-info btn-sm" title="Visualizar"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewModal"
                            data-id="<?= $usuario['id_usuarios'] ?>"
                            data-nome="<?= htmlspecialchars($usuario['nome']) ?>"
                            data-foto="<?= htmlspecialchars($foto_caminho) ?>">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-warning btn-sm" title="Editar"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-id="<?= $usuario['id_usuarios'] ?>"
                            data-nome="<?= htmlspecialchars($usuario['nome']) ?>">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <a href="excluir_usuario.php?id=<?= $usuario['id_usuarios'] ?>" class="btn btn-danger btn-sm" title="Excluir" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">
                        <i class="bi bi-trash3"></i>
                    </a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center py-4'>Nenhum aluno encontrado. Use o botão acima para cadastrar o primeiro aluno.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastrar novo aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="adicionar_usuario.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="addUserName" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="addUserName" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="addUserPhoto" class="form-label">Foto do aluno (opcional)</label>
                        <input type="file" class="form-control" id="addUserPhoto" name="foto" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Cadastrar aluno</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="viewUserPhoto" src="" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                <p><strong>ID:</strong> <span id="viewUserId"></span></p>
                <p><strong>Nome:</strong> <span id="viewUserName"></span></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar aluno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="editar_usuario.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="editUserId" name="id_usuario">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="editUserName" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="editUserPhoto" class="form-label">Alterar foto (opcional)</label>
                        <input type="file" class="form-control" id="editUserPhoto" name="foto" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const viewModal = document.getElementById('viewModal');
viewModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const foto = button.getAttribute('data-foto');

    viewModal.querySelector('#viewUserId').textContent = id;
    viewModal.querySelector('#viewUserName').textContent = nome;
    viewModal.querySelector('#viewUserPhoto').src = foto;
});

const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');

    editModal.querySelector('#editUserId').value = id;
    editModal.querySelector('#editUserName').value = nome;
});
</script>

<?php
renderFooter();
mysqli_close($conexao);
?>