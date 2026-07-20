<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<h1>Situation des Clients</h1>
<h2>Date de la situation : </h2>
<input type="date" id="situation-date" name="situation-date" value="<?= date('Y-m-d') ?>" onchange="updateSituation()">
<table class="table">
    <thead>
        <tr>
            <th>Nom</th>
            <th> Téléphone</th>
            <th>Solde</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= esc($client['nom']) ?></td>
                <td><?= esc($client['telephone']) ?></td>
                <td><?= esc($client['solde']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
<?= $this->include('layout/footer') ?>
<script>
    function updateSituation() {
        const date = document.getElementById('situation-date').value;
        window.location.href = `<?= site_url('operateur/situation') ?>?date=${date}`;
    }
</script>