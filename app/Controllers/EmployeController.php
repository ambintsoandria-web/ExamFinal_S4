<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\UserModel;
use App\Models\TypeCongesModel;

class EmployeController extends BaseController
{
    protected UserModel $userModel;
    protected CongesModel $congesModel;
    protected TypeCongesModel $typeCongesModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->congesModel = new CongesModel();
        $this->typeCongesModel = new TypeCongesModel();
    }
    public function createDemande()
    {
        $rules = [
            'typeCongesId' => 'required|is_natural_no_zero',
            'dateDebut' => 'required|valid_date[Y-m-d]',
            'dateFin' => 'required|valid_date[Y-m-d]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $user = session()->get('user');
        $userId = $user['id'] ?? null;

        if (!$userId) {
            return redirect()->to('/login')
                ->with('erreur', 'Votre session a expiré. Veuillez vous reconnecter.');
        }

        $typeCongesId = (int) $this->request->getPost('typeCongesId');
        $dateDebut = (string) $this->request->getPost('dateDebut');
        $dateFin = (string) $this->request->getPost('dateFin');
        $motif = trim((string) $this->request->getPost('motif'));

        if ($dateFin < $dateDebut) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['dateFin' => 'La date de fin doit être postérieure à la date de début.']);
        }

        $duree = $this->congesModel->getDuree($dateDebut, $dateFin);

        $inserted = $this->congesModel->insert([
            'employee_id' => $userId,
            'type_conge_id' => $typeCongesId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'nb_jours' => $duree,
            'motif' => $motif,
            'statut' => 'en_attente',
            'commentaire_rh' => null,
            'traite_par' => null
        ]);

        if ($inserted === false) {
            return redirect()->back()
                ->withInput()
                ->with('erreur', 'La demande n’a pas pu être enregistrée.');
        }

        return redirect()->to('/employe')
            ->with('success', 'Demande soumise avec succès.');
    }
}
