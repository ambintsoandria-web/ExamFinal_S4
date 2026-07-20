<?= view('partials/head', ['title' => 'TechMada RH']) ?>
<section id="page-dashboard-employe" style="margin-top:3rem">
    <div class="app-wrap">

        <!-- SIDEBAR EMPLOYÉ -->
        <?= view('partials/sidebar', ['activeMenu' => $activeMenu ?? 'dashboard']) ?>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Tableau de bord</div>
                    <div class="topbar-breadcrumb">Accueil</div>
                </div>
                <div class="topbar-actions">
                    <a href="/employe/demandes/nouvelle" class="btn-forest" style="padding:7px 14px;font-size:.82rem">
                        <i class="bi bi-plus-lg"></i> Nouvelle demande
                    </a>
                </div>
            </div>

            <div class="content">

                <!-- Flash succès -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash flash-success">
                        <i class="bi bi-check-circle-fill"></i>
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <!-- Métriques -->
                <div class="metrics">
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div>
                        </div>
                        <div class="metric-val">
                            <?= $enAttente ?>
                        </div>
                        <div class="metric-label">En attente</div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div>
                        </div>
                        <div class="metric-val"><?= $approuves ?></div>
                        <div class="metric-label">Approuvées</div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div>
                        </div>
                        <div class="metric-val"><?= esc($soldeAnnuel['restants']) ?></div>
                        <div class="metric-label">Jours restants</div>
                        <div class="metric-sub">sur
                            <?= esc($soldeAnnuel['attribues']) ?> cette année
                        </div>
                    </div>
                    <div class="metric">
                        <div class="metric-top">
                            <div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div>
                        </div>
                        <div class="metric-val"><?= $refusee ?></div>
                        <div class="metric-label">Refusée</div>
                    </div>
                </div>
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Mes soldes de congés — 2025</h3>
                    </div>
                    <div
                        style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">

                        <?php foreach ($types as $type): ?>
                            <div class="solde-card" style="margin:0">
                                <div class="solde-header">
                                    <span class="solde-type"><?= esc($type['libelle']) ?></span>
                                    <span class="solde-nums"><strong><?= esc($type['jours_restants']) ?></strong> /
                                        <?= esc($type['jours_attribues']) ?> j</span>
                                </div>
                                <div class="solde-bar">
                                    <div class="solde-fill" style="width:<?= esc($type['pourcentage_restant']) ?>%"></div>
                                </div>
                                <div class="solde-label"><?= esc($type['jours_restants']) ?> jours restants · <?= esc($type['jours_pris']) ?> pris
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div> <!-- Dernières demandes -->
                <div class="data-card">
                    <div class="data-card-head">
                        <h3>Mes dernières demandes</h3>
                        <a href="/employe/demandes"
                            style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
                    </div>
                    <table class="tbl">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Du</th>
                                <th>Au</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listeDemande as $d) { ?>
                                <tr>
                                    <td><span class="type-badge t-<?= $d['libelle'] ?>"><?= $d['libelle'] ?></span></td>
                                    <td class="td-muted"><?= $d['date_debut'] ?></td>
                                    <td class="td-muted"><?= $d['date_fin'] ?></td>
                                    <td class="td-mono"><?= esc($d['nb_jours']) ?> j</td>
                                    <td><span class="statut s-<?= esc($d['statut']) ?>"><?= esc($d['statut']) ?></span></td>
                                    <td><button class="btn-sm btn-cancel"><i class="bi bi-x"></i> Annuler</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="footer-app"><i class="bi bi-c-circle"></i> 2025 <span>TechMada RH</span> — Projet CodeIgniter 4
            </div>
        </div>

    </div>
</section>

<?= view('partials/foot') ?>
