<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <title>Statistiques</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: #4CAF50;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .header .caisse-info {
            font-size: 20px;
            font-weight: bold;
        }

        .header .caisse-info span {
            font-weight: normal;
            font-size: 14px;
            opacity: 0.9;
        }

        .header .btn-changer {
            color: white;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 18px;
            border-radius: 5px;
            transition: background 0.3s;
            font-size: 14px;
        }

        .header .btn-changer:hover {
            background: rgba(255, 255, 255, 0.35);
        }

        .menu {
            background: #f8f9fa;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
        }

        .menu ul {
            list-style: none;
            display: flex;
            gap: 5px;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
        }

        .menu ul li a {
            text-decoration: none;
            color: #555;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
            display: inline-block;
        }

        .menu ul li a:hover {
            background: #e9ecef;
            color: #333;
        }

        .menu ul li a.active {
            background: #4CAF50;
            color: white;
        }

        /* CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #4CAF50;
        }

        .stat-card .label {
            color: #888;
            font-size: 14px;
            margin-top: 5px;
        }

        /* GRAPHIQUE SIMPLE */
        .chart-container {
            margin-top: 30px;
            margin-bottom: 30px;
        }

        .chart-container h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 15px;
            height: 200px;
            padding: 10px 0;
            border-bottom: 2px solid #e0e0e0;
        }

        .chart-bar {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .chart-bar .bar {
            width: 100%;
            max-width: 50px;
            background: #4CAF50;
            border-radius: 5px 5px 0 0;
            transition: height 0.5s;
            min-height: 5px;
        }

        .chart-bar .bar:hover {
            background: #43a047;
        }

        .chart-bar .day-label {
            font-size: 12px;
            color: #888;
        }

        .chart-bar .count-label {
            font-size: 12px;
            font-weight: bold;
            color: #555;
        }

        /* TABLEAU UTILISATEURS */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }

        table thead {
            background: #4CAF50;
            color: white;
        }

        table th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tbody tr:hover {
            background: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .empty {
            text-align: center;
            padding: 20px 0;
            color: #999;
        }
    </style>
</head>

<body>

    <?= view('sidebar') ?>

    <div class="main-content">
        <div class="container">

            <div class="header">
                <div class="caisse-info">
                    🏪 Caisse n°
                    <?= $caisse->numero ?? 'Non définie' ?>
                    <?php if (!empty($caisse->caissier)): ?>
                        <span>| 👤
                            <?= $caisse->caissier ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="/choix-caisse" class="btn-changer">⬅ Changer de caisse</a>
                </div>
            </div>
            <h2>📊 Statistiques</h2>

            <!-- CARDS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="number">
                        <?= $totalAchats ?>
                    </div>
                    <div class="label">📋 Total Achats</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        <?= number_format($totalCA, 0, ',', ' ') ?> AR
                    </div>
                    <div class="label">💰 Chiffre d'affaires</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        <?= $totalUsers ?>
                    </div>
                    <div class="label">👥 Utilisateurs</div>
                </div>
                <div class="stat-card">
                    <div class="number">
                        <?= $totalProduits ?>
                    </div>
                    <div class="label">📦 Produits</div>
                </div>
            </div>

            <!-- GRAPHIQUE SIMPLE - Achats par jour -->
            <div class="chart-container">
                <h3>📈 Achats par jour (7 derniers jours)</h3>
                <div class="chart-bars">
                    <?php
                    $max = 0;
                    foreach ($achatsParJour as $jour) {
                        if ($jour['count'] > $max)
                            $max = $jour['count'];
                    }
                    if ($max == 0)
                        $max = 1;

                    foreach ($achatsParJour as $jour):
                        $hauteur = ($jour['count'] / $max) * 150;
                        ?>
                        <div class="chart-bar">
                            <div class="count-label">
                                <?= $jour['count'] ?>
                            </div>
                            <div class="bar" style="height: <?= max($hauteur, 10) ?>px;"></div>
                            <div class="day-label">
                                <?= $jour['date'] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- TOP UTILISATEURS -->
            <h3>🏆 Top utilisateurs par achats</h3>
            <?php if (!empty($achatsParUser) && count($achatsParUser) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th class="text-right">Nb achats</th>
                            <th class="text-right">Total dépensé</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($achatsParUser as $user): ?>
                            <tr>
                                <td>
                                    <?= $user->nom_complet ?? 'Utilisateur inconnu' ?>
                                </td>
                                <td class="text-right">
                                    <?= $user->nb_achats ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($user->total ?? 0, 0, ',', ' ') ?> AR
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">
                    <p>Aucun achat effectué</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>