<?php
session_start();
require_once 'config/config_bd.php';
require_once 'includes/header.php';
renderHeader('Autores - Biblioteca E.E. Bueno Brandão');
?>

<div class="page-header p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div>
            <h1 class="h2 fw-bold mb-2">Autores</h1>
            <p class="text-muted mb-0">Cadastre e gerencie os autores dos livros da biblioteca.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                <i class="bi bi-person-plus me-2"></i>Adicionar autor
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Voltar ao início</a>
        </div>
    </div>
</div>

<?php
$sql = "SELECT id_autor, nome, pais FROM autores ORDER BY nome ASC";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="table-responsive mb-5">
    <table class="table table-striped table-hover align-middle rounded-4 overflow-hidden shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>País</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($autor = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($autor['id_autor']) ?></td>
                        <td><?= htmlspecialchars($autor['nome']) ?></td>
                        <td><?= htmlspecialchars($autor['pais']) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" title="Editar" data-bs-toggle="modal" data-bs-target="#editAuthorModal"
                                data-id="<?= $autor['id_autor'] ?>"
                                data-nome="<?= htmlspecialchars($autor['nome']) ?>"
                                data-pais="<?= htmlspecialchars($autor['pais']) ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="excluir_autor.php?id=<?= $autor['id_autor'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este autor?');" title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center py-4">Nenhum autor encontrado. Adicione o primeiro autor.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addAuthorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar autor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="adicionar_autor.php" method="POST">
                    <div class="mb-3">
                        <label for="authorName" class="form-label">Nome</label>
                        <input type="text" id="authorName" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="authorCountry" class="form-label">País</label>
                        <input type="text" id="authorCountry" name="pais" class="form-control">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Salvar autor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editAuthorModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar autor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="editar_autor.php" method="POST">
                    <input type="hidden" id="editAuthorId" name="id_autor">
                    <div class="mb-3">
                        <label for="editAuthorName" class="form-label">Nome</label>
                        <input type="text" id="editAuthorName" name="nome" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editAuthorCountry" class="form-label">País</label>
                        <input type="text" id="editAuthorCountry" name="pais" class="form-control">
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
const editAuthorModal = document.getElementById('editAuthorModal');
editAuthorModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    editAuthorModal.querySelector('#editAuthorId').value = button.getAttribute('data-id');
    editAuthorModal.querySelector('#editAuthorName').value = button.getAttribute('data-nome');
    editAuthorModal.querySelector('#editAuthorCountry').value = button.getAttribute('data-pais');
});
</script>

<?php
renderFooter();
mysqli_close($conexao);
?>