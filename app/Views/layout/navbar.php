<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mobile Money' ?></title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">

    <style>
    </style>
</head>

<body>

    <!-- ============================================
     OVERLAY (mobile)
     ============================================ -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ============================================
     NAVBAR (barre du haut)
     ============================================ -->
    <nav class="navbar-custom">
        <!-- Toggle Sidebar (mobile) -->
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        <a href="<?= base_url('dashboard') ?>" class="brand">
            <span class="brand-mark"><i class="bi bi-phone"></i></span>
            Mobile Money
        </a>

        <div class="nav-right">
            <div class="nav-user">
                <div class="avatar">
                    <?= esc(strtoupper(substr(session('auth_nom') ?? 'OP', 0, 2))) ?>
                </div>
                <span><?= esc(session('auth_nom') ?? 'Opérateur') ?></span>
            </div>
            <form action="<?= site_url('deconnexion') ?>" method="post" class="logout-form">
                <?= csrf_field() ?>
                <button type="submit" class="logout-btn" aria-label="Se déconnecter" title="Se déconnecter">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </nav>

    <!-- ============================================
     SIDEBAR (menu latéral)
     ============================================ -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-label">Menu principal</div>
        <ul class="sidebar-menu">
            <li>
                <a href="<?= site_url('operateur/prefixes') ?>"
                    class="<?= ($active ?? '') == 'prefixes' ? 'active' : '' ?>">
                    <i class="bi bi-hash"></i>
                    Préfixes
                </a>
            </li>
            <li>
                <a href="<?= base_url('operateur/operations') ?>"
                    class="<?= ($active ?? '') == 'operations' ? 'active' : '' ?>">
                    <i class="bi bi-arrow-left-right"></i>
                    Opérations
                </a>
            </li>
            <li>
                <a href="<?= base_url('operateur/clients') ?>"
                    class="<?= ($active ?? '') == 'clients' ? 'active' : '' ?>">
                    <i class="bi bi-people"></i>
                    Clients
                    <span class="badge"><?= $total_clients ?? 0 ?></span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('operateur/gains') ?>" class="<?= ($active ?? '') == 'gains' ? 'active' : '' ?>">
                    <i class="bi bi-graph-up-arrow"></i>
                    Gains
                </a>
            </li>
        </ul>

        <!-- Version -->
        <div
            style="margin-top: auto; padding: 20px 16px 0; border-top: 1px solid var(--line); font-size: 12px; color: var(--muted);">
            <i class="bi bi-code-square"></i> Version 1.0
        </div>
    </aside>

    <!-- ============================================
     CONTENU PRINCIPAL
     ============================================ -->
    <div class="main-content">
        <div class="page-content">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <?= $this->include('layout/footer') ?>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
