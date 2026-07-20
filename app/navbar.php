<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Money - <?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="bi bi-phone"></i> Mobile Money
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">

                    <!-- Préfixes -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'prefixes') ? 'active' : '' ?>"
                            href="<?= base_url('operateur/prefixes') ?>">
                            <i class="bi bi-hash"></i> Préfixes
                        </a>
                    </li>

                    <!-- Gestion Opérations -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'operations') ? 'active' : '' ?>"
                            href="<?= base_url('operateur/operations') ?>">
                            <i class="bi bi-arrow-left-right"></i> Opérations
                        </a>
                    </li>

                    <!-- Gestion Clients -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'clients') ? 'active' : '' ?>"
                            href="<?= base_url('operateur/clients') ?>">
                            <i class="bi bi-people"></i> Clients
                        </a>
                    </li>

                    <!-- Situation Gains -->
                    <li class="nav-item">
                        <a class="nav-link <?= ($active == 'gains') ? 'active' : '' ?>"
                            href="<?= base_url('operateur/gains') ?>">
                            <i class="bi bi-graph-up-arrow"></i> Gains
                        </a>
                    </li>

                </ul>

                <!-- Info opérateur + Déconnexion -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?= session()->get('nom') ?? 'Opérateur' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">