<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
    <h1>Modifier un frais</h1>
    <form method="post" action="<?= site_url('frais/update/' . $frais['id']) ?>">
        <div class="form-group">
            <label for="montant_min">Montant minimum</label>
            <input type="number" class="form-control" id="montant_min" name="montant_min" value="<?= $frais['montant_min'] ?>" required>
        </div>
        <div class="form-group">
            <label for="montant_max">Montant maximum</label>
            <input type="number" class="form-control" id="montant_max" name="montant_max" value="<?= $frais['montant_max'] ?>" required>
        </div>
        <div class="form-group">
            <label for="montant_frais">Frais</label>
            <input type="number" class="form-control" id="montant_frais" name="montant_frais" value="<?= $frais['montant_frais'] ?>" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
<?= $this->endSection() ?>
<?= $this->include('layout/footer') ?>