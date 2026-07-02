<?php
require_once __DIR__ . '/footer.php';

function renderHeader($title = 'Biblioteca E.E. Bueno Brandão') {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title) ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <style>
            body {
                min-height: 100vh;
                background: linear-gradient(180deg, #f8fafc 0%, #e9f1fb 100%);
                display: flex;
                flex-direction: column;
            }
            .page-header {
                background: #ffffff;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
            }
            .feature-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
            }
            footer {
                background: #0b2e60;
                color: #f8fafc;
            }
            .icon-circle {
                width: 3rem;
                height: 3rem;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                border-radius: 50%;
                background: rgba(13, 110, 253, 0.1);
                color: #0d6efd;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhMvooX-JVIdWyWUuwTLgBWIDoc2pyWFjd06x_S3LqqSraBSX5QFKoqRV5JAtidRm5IOyGkP8r0g8z-fOOjQVqwpE4GnxesyspNGmTKUTQ57yC1XGCCQ6JQpQSnSWDrC-Joq61cg0GTjgU/s1600/logo_bueno_1.png" alt="Logo E.E. Bueno Brandão" style="width: 48px; height: 48px; object-fit: contain;" class="me-2">
                    <div>
                        <div>Biblioteca</div>
                        <small class="text-muted" style="font-size: 0.85rem;">E.E. Bueno Brandão</small>
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="listar_usuarios.php">Usuários</a></li>
                        <li class="nav-item"><a class="nav-link" href="listar_livros.php">Livros</a></li>
                        <li class="nav-item"><a class="nav-link" href="listar_autores.php">Autores</a></li>
                        <li class="nav-item"><a class="nav-link" href="emprestimos.php">Empréstimos</a></li>
                        <li class="nav-item"><a class="nav-link" href="devedores.php">Devedores</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container flex-grow-1 py-5">
    <?php
}
?>