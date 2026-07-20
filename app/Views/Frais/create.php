<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<h1>Ajouter un frais</h1>
<p>Type d'opération : <strong><?= esc(ucfirst($typeOperation['nom'])) ?></strong></p>

<?php if (session('erreur')): ?>
    <div class="prefix-alert prefix-alert-error" role="alert"><?= esc(session('erreur')) ?></div>
<?php endif; ?>

<form method="post" action="<?= site_url('frais/add') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="type_operation_id" value="<?= esc($typeOperationId) ?>">

    <div class="form-group">
        <label for="montant_min">Montant minimum</label>
        <input type="number" class="form-control" id="montant_min" name="montant_min"
            value="<?= esc(old('montant_min')) ?>" min="0" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="montant_max">Montant maximum</label>
        <input type="number" class="form-control" id="montant_max" name="montant_max"
            value="<?= esc(old('montant_max')) ?>" min="0" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="montant_frais">Frais</label>
        <input type="number" class="form-control" id="montant_frais" name="montant_frais"
            value="<?= esc(old('montant_frais')) ?>" min="0" step="0.01" required>
    </div>
    <button type="submit" class="save-button">Enregistrer</button>
</form>

<?= $this->endSection() ?>