<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Espace opérateur | Vola</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>

<body class="dashboard-page">
    <main class="dashboard-card operator-dashboard"><span class="brand dark-brand"><span
                class="brand-mark">V</span>Vola</span>
        <p class="section-label">Portail opérateur</p>
        <h1>Bonjour, <?= esc($operateur['nom']) ?></h1>
        <p>Votre session professionnelle est active.</p>
        <p class="account-number"><?= esc($operateur['telephone']) ?></p>
        <form action="<?= site_url('deconnexion') ?>" method="post"><?= csrf_field() ?><button class="primary-button"
                type="submit">Se déconnecter</button></form>
    </main>
</body>

</html>