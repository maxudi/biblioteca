<?php
session_start();
require_once 'config/config_bd.php';
require_once 'includes/header.php';
renderHeader('Livros - Biblioteca E.E. Bueno Brandão');
?>

<div class="page-header p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div>
            <h1 class="h2 fw-bold mb-2">Catálogo de livros</h1>
            <p class="text-muted mb-0">Gerencie os livros disponíveis na biblioteca e mantenha o acervo sempre atualizado.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">
                <i class="bi bi-bookmark-plus me-2"></i>Adicionar livro
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Voltar ao início</a>
        </div>
    </div>
</div>

<?php
$sql = "SELECT l.id_livro, l.titulo, IFNULL(a.nome, 'Sem autor') AS autor, l.ano, l.status FROM livros l LEFT JOIN autores a ON l.autor_id = a.id_autor ORDER BY l.titulo ASC";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="table-responsive mb-5">
    <table class="table table-striped table-hover align-middle rounded-4 overflow-hidden shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Ano</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($livro = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($livro['id_livro']) ?></td>
                        <td><?= htmlspecialchars($livro['titulo']) ?></td>
                        <td><?= htmlspecialchars($livro['autor']) ?></td>
                        <td><?= htmlspecialchars($livro['ano']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($livro['status'])) ?></td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" title="Editar" data-bs-toggle="modal" data-bs-target="#editBookModal"
                                data-id="<?= $livro['id_livro'] ?>"
                                data-titulo="<?= htmlspecialchars($livro['titulo']) ?>"
                                data-autor="<?= htmlspecialchars($livro['autor']) ?>"
                                data-ano="<?= htmlspecialchars($livro['ano']) ?>"
                                data-status="<?= htmlspecialchars($livro['status']) ?>">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="excluir_livro.php?id=<?= $livro['id_livro'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?');" title="Excluir">
                                <i class="bi bi-trash3"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="text-center py-4">Nenhum livro encontrado. Adicione seu primeiro título.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="adicionar_livro.php" method="POST">
                    <div class="mb-3">
                        <label for="bookTitle" class="form-label">Título</label>
                        <input type="text" id="bookTitle" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookAuthor" class="form-label">Autor</label>
                        <select id="bookAuthor" name="autor_id" class="form-select">
                            <option value="">Selecionar autor</option>
                            <?php
                            $autores = mysqli_query($conexao, "SELECT id_autor, nome FROM autores ORDER BY nome ASC");
                            if ($autores) {
                                while ($autor = mysqli_fetch_assoc($autores)) {
                                    echo '<option value="' . htmlspecialchars($autor['id_autor']) . '">' . htmlspecialchars($autor['nome']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bookYear" class="form-label">Ano</label>
                        <input type="number" id="bookYear" name="ano" class="form-control" placeholder="Ex: 2024">
                    </div>
                    <div class="mb-3">
                        <label for="bookStatus" class="form-label">Status</label>
                        <select id="bookStatus" name="status" class="form-select">
                            <option value="disponivel">Disponível</option>
                            <option value="emprestado">Emprestado</option>
                            <option value="reservado">Reservado</option>
                        </select>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Salvar livro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBookModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar livro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="editar_livro.php" method="POST">
                    <input type="hidden" id="editBookId" name="id_livro">
                    <div class="mb-3">
                        <label for="editBookTitle" class="form-label">Título</label>
                        <input type="text" id="editBookTitle" name="titulo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="editBookYear" class="form-label">Ano</label>
                        <input type="number" id="editBookYear" name="ano" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="editBookStatus" class="form-label">Status</label>
                        <select id="editBookStatus" name="status" class="form-select">
                            <option value="disponivel">Disponível</option>
                            <option value="emprestado">Emprestado</option>
                            <option value="reservado">Reservado</option>
                        </select>
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
const editBookModal = document.getElementById('editBookModal');
editBookModal.addEventListener('show.bs.modal', event => {
    const button = event.relatedTarget;
    editBookModal.querySelector('#editBookId').value = button.getAttribute('data-id');
    editBookModal.querySelector('#editBookTitle').value = button.getAttribute('data-titulo');
    editBookModal.querySelector('#editBookYear').value = button.getAttribute('data-ano');
    editBookModal.querySelector('#editBookStatus').value = button.getAttribute('data-status');
});
</script>

<?php
renderFooter();
mysqli_close($conexao);
?>