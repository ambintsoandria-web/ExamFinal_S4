<?php
$user = session()->get('user') ?? [];
$role = $user['role'] ?? 'employe';
$activeMenu = $activeMenu ?? 'dashboard';
$fullName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur';
$initials = strtoupper(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1));

$spaces = [
    'admin' => ['label' => 'Administration', 'icon' => 'bi-shield-check', 'section' => 'Gestion'],
    'rh' => ['label' => 'Espace responsable', 'icon' => 'bi-person-check', 'section' => 'Menu'],
    'employe' => ['label' => 'Espace employé', 'icon' => 'bi-briefcase', 'section' => 'Menu'],
];
$space = $spaces[$role] ?? $spaces['employe'];

$menus = [
    'admin' => [
        ['dashboard', '/admin', 'bi-speedometer2', "Vue d'ensemble"],
        ['demandes', '/admin/demandes', 'bi-inbox', 'Toutes les demandes', '4'],
        ['employes', '/admin/employes', 'bi-people', 'Employés'],
        ['departement', '/admin/departement', 'bi-building', 'Départements'],
        ['recherche', '/admin/recherche', 'bi-people', 'Recherche'],
        ['types', '/admin/employes', 'bi-tags', 'Types de congé'],
        ['soldes', '/admin/employes', 'bi-sliders', 'Soldes annuels'],
    ],
    'rh' => [
        ['dashboard', '/rh', 'bi-grid-1x2', 'Tableau de bord'],
        ['demandes', '/rh', 'bi-inbox', 'Demandes à traiter', '4'],
        ['historique', '/rh', 'bi-archive', 'Historique'],
        ['soldes', '/rh', 'bi-people', 'Soldes employés'],
    ],
    'employe' => [
        ['dashboard', '/employe', 'bi-grid-1x2', 'Tableau de bord'],
        ['nouvelle', '/employe/demandes/nouvelle', 'bi-plus-circle', 'Nouvelle demande'],
        ['demandes', '/employe/demandes', 'bi-calendar3', 'Mes demandes', '2'],
        ['profil', '/employe', 'bi-person', 'Mon profil'],
    ],
];
?>
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo-icon"><i class="bi <?= esc($space['icon']) ?>"></i></div>
        <div class="sidebar-brand-name">TechMada RH<span><?= esc($space['label']) ?></span></div>
    </div>
    <div class="sidebar-section"><?= esc($space['section']) ?></div>
    <ul class="sidebar-nav">
        <?php foreach ($menus[$role] ?? $menus['employe'] as $item): ?>
            <?php [$key, $url, $icon, $label] = $item; ?>
            <li>
                <a href="<?= site_url(ltrim($url, '/')) ?>" class="<?= $activeMenu === $key ? 'active' : '' ?>">
                    <i class="bi <?= esc($icon) ?>"></i> <?= esc($label) ?>
                    <?php if (isset($item[4])): ?><span class="nav-badge alert"><?= esc($item[4]) ?></span><?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="sidebar-user">
        <div class="s-user-row">
            <div class="avatar av-green"><?= esc($initials) ?></div>
            <div>
                <div class="user-name"><?= esc($fullName) ?></div>
                <div class="user-role"><?= esc(ucfirst($role)) ?></div>
            </div>
            <a href="<?= site_url('logout') ?>" title="Déconnexion"
                style="margin-left:auto;color:rgba(255,255,255,.5);font-size:1.1rem">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</aside>