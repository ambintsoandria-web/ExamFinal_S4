<?php
namespace App\Controllers;
use App\Models\OperateurModel;

error_reporting(E_ALL);
ini_set('display_errors', 1);


class OperateurController extends BaseController
{
    private OperateurModel $operateurModel;
    public function __construct()
    {
        $this->operateurModel = new OperateurModel();
    }
    public function goToPrefixe()
    {

        return view('Operateur/prefixe');
    }
    public function login()
    {
        if (session('auth_type') === 'operateur') {
            return redirect()->to(site_url('operateur/espace'));
        }
        return view('Operateur/loginOperateur');
    }

    public function authenticate()
    {
        $identifiant = trim((string) $this->request->getPost('identifiant'));
        $password = (string) $this->request->getPost('mot_de_passe');
        if ($identifiant === '' || $password === '') {
            return redirect()->back()->withInput()->with('erreur', 'Renseignez votre identifiant et votre mot de passe.');
        }
        $operateur = $this->operateurModel->authenticate($identifiant, $password);
        if (!$operateur) {
            return redirect()->back()->withInput()->with('erreur', 'Identifiants incorrects ou compte desactive.');
        }
        session()->regenerate();
        session()->set([
            'auth_id' => (int) $operateur['id'],
            'auth_type' => 'operateur',
            'auth_nom' => $operateur['nom'],
            'auth_telephone' => $operateur['telephone'],
            'logged_in' => true,
        ]);
        return redirect()->to(site_url('operateur/goToprefixe'))->with('succes', 'Connexion operateur reussie.');
    }

    public function dashboard()
    {
        $operateur = $this->operateurModel->find((int) session('auth_id'));
        if (!$operateur || (int) $operateur['actif'] !== 1) {
            session()->destroy();
            return redirect()->to(site_url('connexion/operateur'))->with('erreur', 'Votre compte operateur est indisponible.');
        }
        return view('Operateur/dashboard', ['operateur' => $operateur]);
    }
}
