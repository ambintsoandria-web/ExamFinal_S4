<?= $this->extend('layout/navbar') ?>
<?= $this->section('content') ?>

<?php if (session('succes')): ?>
    <div class="prefix-alert prefix-alert-success"><?= esc(session('succes')) ?></div>
<?php endif; ?>


<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mon espace | Vola</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>

<body class="dashboard-page">
    <main class="dashboard-card"><span class="brand dark-brand"><span class="brand-mark">V</span>Vola</span>
        <p class="section-label">Espace client</p>
        <h1>Bonjour, <?= esc($client['nom']) ?></h1>
        <p>Votre solde disponible</p><strong class="balance"><?= number_format((float) $client['solde'], 0, ',', ' ') ?>
            Ar</strong>
        <p class="account-number"><?= esc($client['telephone']) ?></p>
        <form action="<?= site_url('deconnexion') ?>" method="post"><?= csrf_field() ?><button class="primary-button"
                type="submit">Se déconnecter</button></form>
    </main>
</body>

</html>
<?= $this->endSection() ?>
