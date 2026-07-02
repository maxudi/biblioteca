<?php
session_start();
require_once 'config/config_bd.php';
require_once 'includes/header.php';
renderHeader('Empréstimos - Biblioteca E.E. Bueno Brandão');
?>

<div class="page-header p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div>
            <h1 class="h2 fw-bold mb-2">Empréstimos</h1>
            <p class="text-muted mb-0">Registre empréstimos, devoluções e acompanhe o status dos livros.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLoanModal">
                <i class="bi bi-arrow-right-square me-2"></i>Novo empréstimo
            </button>
            <a href="index.php" class="btn btn-outline-secondary">Voltar ao início</a>
        </div>
    </div>
</div>

<?php
$sql = "SELECT e.id_emprestimo, u.nome AS aluno, l.titulo AS livro, e.data_emprestimo, e.data_devolucao, e.status FROM emprestimos e JOIN usuarios u ON e.usuario_id = u.id_usuarios JOIN livros l ON e.livro_id = l.id_livro ORDER BY e.data_emprestimo DESC";
$resultado = mysqli_query($conexao, $sql);
?>

<div class="table-responsive mb-5">
    <table class="table table-striped table-hover align-middle rounded-4 overflow-hidden shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Aluno</th>
                <th>Livro</th>
                <th>Empréstimo</th>
                <th>Devolução</th>
                <th>Status</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && mysqli_num_rows($resultado) > 0): ?>
                <?php while ($emprestimo = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td><?= htmlspecialchars($emprestimo['id_emprestimo']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['aluno']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['livro']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['data_emprestimo']) ?></td>
                        <td><?= htmlspecialchars($emprestimo['data_devolucao']) ?></td>
                        <td><?= htmlspecialchars(ucfirst($emprestimo['status'])) ?></td>
                        <td class="text-center">
                            <a href="devolver_livro.php?id=<?= $emprestimo['id_emprestimo'] ?>" class="btn btn-success btn-sm" title="Registrar devolução" onclick="return confirm('Confirma a devolução deste livro?');">
                                <i class="bi bi-check2-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center py-4">Nenhum empréstimo registrado ainda.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addLoanModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar novo empréstimo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="adicionar_emprestimo.php" method="POST">
                    <div class="mb-3">
                        <label for="loanUser" class="form-label">Aluno</label>
                        <select id="loanUser" name="usuario_id" class="form-select" required>
                            <option value="">Selecione um aluno</option>
                            <?php
                            $alunos = mysqli_query($conexao, "SELECT id_usuarios, nome FROM usuarios ORDER BY nome ASC");
                            if ($alunos) {
                                while ($aluno = mysqli_fetch_assoc($alunos)) {
                                    echo '<option value="' . htmlspecialchars($aluno['id_usuarios']) . '">' . htmlspecialchars($aluno['nome']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="loanBook" class="form-label">Livro</label>
                        <select id="loanBook" name="livro_id" class="form-select" required>
                            <option value="">Selecione um livro</option>
                            <?php
                            $livros = mysqli_query($conexao, "SELECT id_livro, titulo FROM livros WHERE status = 'disponivel' ORDER BY titulo ASC");
                            if ($livros) {
                                while ($livro = mysqli_fetch_assoc($livros)) {
                                    echo '<option value="' . htmlspecialchars($livro['id_livro']) . '">' . htmlspecialchars($livro['titulo']) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="loanDate" class="form-label">Data de empréstimo</label>
                        <input type="date" id="loanDate" name="data_emprestimo" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Data de devolução</label>
                        <input type="date" id="dueDate" name="data_devolucao" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrar empréstimo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
renderFooter();
mysqli_close($conexao);
?>