<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Ajouter un préfixe</div>
    <div class="card-body">
        <form action="<?= base_url('operateur/prefixes/add') ?>" method="post">
            <div class="mb-3">
                <label>Nom du préfixe</label>
                <input type="text" name="prefix" class="form-control" placeholder="Ex: 040" required>
            </div>
            <button type="submit" class="btn btn-success">Enregistrer</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->include('layout/footer') ?>