<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
<h1>Gains</h1>
<p>Total Gains: <?= $totalGains['frais'] ?? 0 ?></p>
<h2>Repartition des gains par type d'operation</h2>
<table>
    <thead>
        <tr>
            <th>Type d'operation</th>
            <th>Total Gains</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($gainsParTypeOperation as $gain): ?>
            <tr>
                <td><?= $gain['type_operation']['libelle'] ?></td>
                <td><?= $gain['total_gains'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>
<?= $this->include('layout/footer') ?>