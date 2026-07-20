<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\TransactionModel;
use App\Models\ClientSoldeHistorique;

class ClientController extends BaseController
{
    protected ClientModel $clientModel;
    public TransactionModel $transactionModel;
    public ClientSoldeHistorique $clientSoldeHistorique;


    public function __construct()
    {
        $this->clientModel = new ClientModel();
        $this->transactionModel = new TransactionModel();
        $this->clientSoldeHistorique = new ClientSoldeHistorique();
    }

    public function login()
    {
        if (session('auth_type') === 'client') {
            return redirect()->to(site_url('client/espace'));
        }
        if (session('auth_type') === 'operateur') {
            return redirect()->to(site_url('operateur/espace'));
        }
        return view('Client/loginClient');
    }

    public function authenticate()
    {
        $telephone = preg_replace('/\s+/', '', (string) $this->request->getPost('telephone'));
        if (! preg_match('/^0[0-9]{9}$/', $telephone)) {
            return redirect()->back()->withInput()->with('erreur', 'Saisissez un numero valide de 10 chiffres.');
        }
        $client = $this->clientModel->login_auto($telephone);
        if (! $client) {
            return redirect()->back()->withInput()->with('erreur', 'Ce numero ne correspond a aucun client actif.');
        }
        session()->regenerate();
        session()->set([
            'auth_id' => (int) $client['id'],
            'auth_type' => 'client',
            'auth_nom' => $client['nom'],
            'auth_telephone' => $client['telephone'],
            'logged_in' => true,
        ]);
        return redirect()->to(site_url('client/espace'))->with('succes', 'Bienvenue ' . $client['nom'] . ' !');
    }

    public function dashboard()
    {
        $client = $this->clientModel->find((int) session('auth_id'));
        if (! $client || (int) $client['actif'] !== 1) {
            session()->destroy();
            return redirect()->to(site_url('/'))->with('erreur', 'Votre compte client est indisponible.');
        }
        return view('Client/dashboard', ['client' => $client]);
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('/'))->with('succes', 'Vous avez été déconnecté avec succès.');
    }
    public function getSituationClients(){
        $clients = $this->clientModel->findAll();
        $date = date('Y-m-d H:i:s');
        foreach ($clients as &$client) {
            $client['solde'] = $this->clientSoldeHistorique->getSoldebyClient($client['id'], $date);
        }
        return view('Client/situation', ['clients' => $clients]);
    }
}
