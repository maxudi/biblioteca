<?php
session_start();
require_once 'config/config_bd.php';
require_once 'includes/header.php';
renderHeader('Devedores - Biblioteca E.E. Bueno Brandão');
?>

<div class="page-header p-4 mb-4">
    <div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3">
        <div>
            <h1 class="h2 fw-bold mb-2">Devedores</h1>
            <p class="text-muted mb-0">Veja quais alunos estão com livros em atraso e acompanhe as devoluções pendentes.</p>
        </div>
        <a href="index.php" class="btn btn-outline-secondary">Voltar ao início</a>
    </div>
</div>

<?php
$sql = "SELECT e.id_emprestimo, u.nome AS aluno, l.titulo AS livro, e.data_emprestimo, e.data_devolucao, e.status FROM emprestimos e JOIN usuarios u ON e.usuario_id = u.id_usuarios JOIN livros l ON e.livro_id = l.id_livro WHERE e.status != 'devolvido' ORDER BY e.data_devolucao ASC";
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
                            <a href="devolver_livro.php?id=<?= $emprestimo['id_emprestimo'] ?>" class="btn btn-success btn-sm" title="Registrar devolução" onclick="return confirm('Registrar devolução deste livro?');">
                                <i class="bi bi-check2-square"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center py-4">Nenhum devedor encontrado no momento.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
renderFooter();
mysqli_close($conexao);
?>