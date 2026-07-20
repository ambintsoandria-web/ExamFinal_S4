<?php

namespace App\Controllers;

error_reporting(E_ALL);
ini_set('display_errors', 1);

use App\Models\ProduitModel;
use App\Models\CaisseModel;
use App\Models\AchatModel;
use App\Models\LigneAchatModel;

class NavigationController extends BaseController
{
    public function goToProduit()
    {
        $produitModel = new ProduitModel();
        $data['produits'] = $produitModel->findAll();
        return view('produits', $data);
    }
    public function goToCaisse()
    {
        $caisse = new CaisseModel();
        $data['caisses'] = $caisse->findAll();
        return view('caisses', $data);
    }
}