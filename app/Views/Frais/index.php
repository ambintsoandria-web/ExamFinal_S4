<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>
    <h1>Gestion des frais</h1>

    <?php foreach ($data as $item): ?>
        <h1>Type d'operation : <?= $item['type_operation']['libelle'] ?></h1>
        <button><a href="<?= site_url('frais/create/' . $item['type_operation']['id']) ?>">Ajouter un frais</a></button>
        <table>
            <thead>
                <tr>
                <th>Montant minimum</th>
                <th>Montant maximum</th>
                <th>Frais</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($item['frais'] as $frais): ?>
                <tr>
                    <td><?= $frais['montant_min'] ?></td>
                    <td><?= $frais['montant_max'] ?></td>
                    <td><?= $frais['montant_frais'] ?></td>
                    <td>
                        <a href="<?= site_url('frais/edit/' . $frais['id']) ?>" class="btn btn-sm btn-primary">Modifier</a>
                        <a href="<?= site_url('frais/delete/' . $frais['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce frais ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endforeach;?>
<?= $this->endSection() ?>
<?= $this->include('layout/footer') ?>