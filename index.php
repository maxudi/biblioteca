<?php
require_once 'includes/header.php';
renderHeader('Biblioteca E.E. Bueno Brandão');
?>

<section id="apresentacao" class="hero mb-5 shadow-sm">
    <div class="row align-items-center">
        <div class="col-lg-7">
            <span class="badge bg-primary bg-opacity-15 text-primary rounded-pill mb-3">Bem-vindo à Biblioteca Escolar</span>
            <h1 class="display-5 fw-semibold">Organize os alunos e deixe a Biblioteca da Escola Estadual Bueno Brandão ainda mais eficiente.</h1>
            <p class="lead text-secondary mb-4">Use o sistema para visualizar, cadastrar, editar e gerenciar os alunos, livros e empréstimos de forma rápida e segura.</p>
            <div class="d-flex flex-column flex-sm-row gap-3">
                <a href="listar_usuarios.php" class="btn btn-primary btn-lg shadow-sm">
                    <i class="bi bi-people-fill me-2"></i>Ver alunos
                </a>
                <a href="listar_livros.php" class="btn btn-outline-primary btn-lg shadow-sm">
                    <i class="bi bi-book-fill me-2"></i>Ver livros
                </a>
            </div>
        </div>
        <div class="col-lg-5 mt-4 mt-lg-0 text-center">
            <div class="p-4 rounded-4" style="background: rgba(13,110,253,0.06);">
                        <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhMvooX-JVIdWyWUuwTLgBWIDoc2pyWFjd06x_S3LqqSraBSX5QFKoqRV5JAtidRm5IOyGkP8r0g8z-fOOjQVqwpE4GnxesyspNGmTKUTQ57yC1XGCCQ6JQpQSnSWDrC-Joq61cg0GTjgU/s1600/logo_bueno_1.png" alt="Logo E.E. Bueno Brandão" class="img-fluid rounded-4 shadow-sm" style="max-height: 320px; object-fit: contain;">
    </div>
</section>

<section id="recursos" class="mb-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="h3 fw-bold">Painel de Atalhos</h2>
            <p class="text-muted mb-0">Navegue rapidamente pelas principais áreas do sistema.</p>
        </div>
        <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary py-2 px-3">Escola Estadual Bueno Brandão</span>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <h5 class="card-title">Alunos</h5>
                    <p class="card-text text-muted">Gerencie o cadastro de alunos, veja fotos e atualize informações sempre que precisar.</p>
                    <a href="listar_usuarios.php" class="stretched-link text-decoration-none text-primary">Abrir lista</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-book"></i>
                    </div>
                    <h5 class="card-title">Livros</h5>
                    <p class="card-text text-muted">Cadastre livros, mantenha o estoque organizado e acompanhe a disponibilidade.</p>
                    <a href="listar_livros.php" class="stretched-link text-decoration-none text-primary">Abrir livros</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card feature-card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="icon-circle mb-3">
                        <i class="bi bi-journal-bookmark"></i>
                    </div>
                    <h5 class="card-title">Empréstimos</h5>
                    <p class="card-text text-muted">Registre empréstimos, devoluções e controle quem está com cada livro.</p>
                    <a href="emprestimos.php" class="stretched-link text-decoration-none text-primary">Abrir empréstimos</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="sobre" class="mb-5">
    <div class="row g-4 align-items-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h3 class="h4 fw-semibold">Uma biblioteca voltada para a comunidade escolar</h3>
                <p class="text-muted">O sistema foi criado para ajudar a equipe da E.E. Bueno Brandão a controlar alunos, livros, autores, empréstimos e devoluções com facilidade.</p>
                <ul class="list-unstyled text-muted mb-0">
                    <li class="d-flex align-items-start mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Interface limpa e moderna.</li>
                    <li class="d-flex align-items-start mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Funciona bem em computadores, tablets e celulares.</li>
                    <li class="d-flex align-items-start mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i>Área de devedores para acompanhar atrasos e devoluções.</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="ratio ratio-4x3 rounded-4 overflow-hidden shadow-sm position-relative bg-dark">
                <img id="videoThumbnail" src="https://img.youtube.com/vi/POq3jYJoDsY/maxresdefault.jpg"
                     alt="Vídeo Biblioteca Escolar"
                     class="position-absolute top-0 start-0 w-100 h-100"
                     style="object-fit: cover;">
                <button id="playVideoButton" type="button"
                        class="btn btn-primary btn-lg rounded-circle position-absolute top-50 start-50 translate-middle shadow-lg"
                        style="width: 80px; height: 80px;">
                    <i class="bi bi-play-fill fs-2"></i>
                </button>
                <div id="videoFrameContainer" class="position-absolute top-0 start-0 w-100 h-100"></div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('playVideoButton');
    const container = document.getElementById('videoFrameContainer');
    const thumb = document.getElementById('videoThumbnail');

    if (btn && container) {
        btn.addEventListener('click', function() {
            container.innerHTML = '<iframe src="https://www.youtube.com/embed/POq3jYJoDsY?autoplay=1" title="Biblioteca Escolar" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-100 h-100 border-0"></iframe>';
            btn.style.display = 'none';
            thumb.style.display = 'none';
        });
    }
});
</script>

<?php
renderFooter();
?>
