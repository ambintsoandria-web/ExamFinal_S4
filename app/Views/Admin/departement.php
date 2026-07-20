<?= view('partials/head', ['title' => 'TechMada RH']) ?>
<?php $formErrors = session()->getFlashdata('errors') ?? []; ?>
<section id="page-admin-employes" style="margin-top:3rem">
    <div class="app-wrap">

        <?= view('partials/sidebar', ['activeMenu' => $activeMenu ?? 'dashboard']) ?>

        <div class="main">
            <div class="topbar">
                <div>
                    <div class="topbar-title">Gestion des départements</div>
                    <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right"
                            style="font-size:.6rem"></i> Départements</div>
                </div>
                <div class="topbar-actions">
                    <a href="#" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i
                            class="bi bi-person-plus"></i>
                        Ajouter</a>
                </div>
            </div>

            <div class="content">

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="flash flash-success"><i
                            class="bi bi-check-circle-fill"></i><?= esc(session()->getFlashdata('success')) ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('erreur')): ?>
                    <div class="flash flash-error"><i
                            class="bi bi-exclamation-circle-fill"></i><?= esc(session()->getFlashdata('erreur')) ?></div>
                <?php endif; ?>
                <?php if ($formErrors): ?>
                    <div class="flash flash-error">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <span><?= esc(implode(' ', $formErrors)) ?></span>
                    </div>
                <?php endif; ?>

                <!-- Formulaire ajout -->
                <form action="<?= site_url('admin/departement/addDepart') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="form-section">
                        <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un
                            départements</h3>
                        <div class="form-grid-2" style="margin-bottom:1rem">
                            <div class="f-group">
                                <label class="f-label">Nom</label>
                                <input type="text" class="f-input" placeholder="Nom" name="nom" required />
                            </div>
                            <div class="f-group">
                                <label class="f-label">Description</label>
                                <input type="text" class="f-input" placeholder="Ecrire ..." name="description"
                                    required />
                            </div>
                            <div class="form-actions">
                                <button class="btn-forest" type="submit"><i class="bi bi-plus"></i> Ajouter le
                                    departement</button>
                                <button class="btn-secondary" type="reset">Annuler</button>
                            </div>
                        </div>
                </form>

                <?= view('partials/foot') ?>