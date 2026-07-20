<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
    <title>Liste des Caisses</title>
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

        .text-center {
            text-align: center;
        }

        .badge-statut {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge-statut.ouverte {
            background: #d4edda;
            color: #155724;
        }

        .badge-statut.fermee {
            background: #f8d7da;
            color: #721c24;
        }

        .empty {
            text-align: center;
            padding: 40px 0;
            color: #999;
        }

        .empty .icon {
            font-size: 50px;
            margin-bottom: 10px;
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

            <div class="menu">
                <ul>
                    <li><a href="/saisie-achat">🛒 Saisie des achats</a></li>
                    <li><a href="/historique">📋 Historique</a></li>
                    <li><a href="/produits">📦 Produits</a></li>
                    <li><a href="#" class="active">🏪 Caisses</a></li>
                </ul>
            </div>

            <h2>🏪 Liste des caisses</h2>

            <?php if (!empty($caisses) && count($caisses) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Numéro</th>
                            <th>Caissier</th>
                            <th class="text-center">Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($caisses as $caisse_item): ?>
                            <tr>
                                <td>#
                                    <?= $caisse_item->id_caisse ?>
                                </td>
                                <td><strong>Caisse n°
                                        <?= $caisse_item->numero ?>
                                    </strong></td>
                                <td>
                                    <?= $caisse_item->caissier ?? '-' ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge-statut <?= $caisse_item->statut ?>">
                                        <?= $caisse_item->statut === 'ouverte' ? '✅ Ouverte' : '❌ Fermée' ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">
                    <div class="icon">🏪</div>
                    <p>Aucune caisse disponible</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>