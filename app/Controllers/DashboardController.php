<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\UserModel;
use App\Models\TypeCongesModel;
use App\Models\DepartementModel;

class DashboardController extends BaseController
{
    protected UserModel $userModel;
    protected CongesModel $congesModel;
    protected TypeCongesModel $typeCongesModel;
    protected DepartementModel $departementModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->congesModel = new CongesModel();
        $this->typeCongesModel = new TypeCongesModel();
        $this->departementModel = new DepartementModel();
    }

    public function admin(): string
    {
        return view('Admin/dashboard', ['activeMenu' => 'dashboard']);
    }

    public function employes(): string
    {
        $search = $this->request->getGet('search');
        $departement = $this->request->getGet('departement');

        $data['listeDepartement'] = $this->departementModel->findAll();
        $data['roles'] = $this->userModel->getRoles();
        $data['listeEmp'] = $this->userModel->findAllEmp($departement, $search);
        $data['search'] = $search;
        $data['selectedDept'] = $departement;

        foreach ($data['listeEmp'] as &$emp) {
            $soldeAnnuelTolal = $this->congesModel->getSoldeAnnuelTotal();
            $soldeAnnuelUtilise = $this->congesModel->getSommeSoldeUtilise($emp['id']);
            $emp['soldeAnnuelUtilise'] = $soldeAnnuelUtilise;
            $emp['soldeAnnuelTolal'] = $soldeAnnuelTolal;
        }
        unset($emp);

        $data['activeMenu'] = 'employes';
        return view('Admin/employes', $data);
    }
    public function departement(): string
    {
        return view('Admin/departement');
    }

    public function filter()
    {
        $search = $this->request->getGet('search');
        $departement = $this->request->getGet('departement');

        $employees = $this->userModel->findAllEmp($departement, $search);

        // Ajouter les soldes pour chaque employé
        foreach ($employees as &$emp) {
            $soldeAnnuelTolal = $this->congesModel->getSoldeAnnuelTotal();
            $soldeAnnuelUtilise = $this->congesModel->getSommeSoldeUtilise($emp['id']);
            $emp['soldeAnnuelUtilise'] = $soldeAnnuelUtilise;
            $emp['soldeAnnuelTolal'] = $soldeAnnuelTolal;
        }
        unset($emp);

        return $this->response->setJSON([
            'success' => true,
            'employees' => $employees
        ]);
    }
    public function recherche()
    {
        $data['departements'] = $this->departementModel->findAll();
        return view('Admin/recherche', $data);
    }
    public function getEmpByDept()
    {
        $deptId = $this->request->getGet('deptId');
        return $this->response->setJSON(
            $this->userModel->where('departement_id', $deptId)->findAll()
        );
    }
    public function getCongeByEmp()
    {
        $empId = $this->request->getGet('empId');

        if (!$empId) {
            return $this->response->setJSON([]);
        }

        return $this->response->setJSON(
            $this->congesModel->where('employee_id', $empId)->findAll()
        );
    }
    public function rh(): string
    {
        return view('Rh/index', ['activeMenu' => 'demandes']);
    }

    public function demandesAdmin(): string
    {
        return view('Rh/index', ['activeMenu' => 'demandes']);
    }

    public function employe(): string
    {
        $user = session()->get('user');
        $userId = $user['id'] ?? null;

        $data['enAttente'] = $this->congesModel->getCount($userId, 'en_attente');
        $data['approuves'] = $this->congesModel->getCount($userId, 'approuvee');
        $data['refusee'] = $this->congesModel->getCount($userId, 'refusee');

        $types = $this->typeCongesModel->findAll();
        $data['types'] = [];
        $data['soldeAnnuel'] = [
            'attribues' => 0,
            'pris' => 0,
            'restants' => 0,
        ];

        foreach ($types as $type) {
            $joursPris = $this->congesModel->getSommeJours($userId, $type['id']);
            $joursAttribues = (int) $type['jours_annuels'];
            $joursRestants = max(0, $joursAttribues - $joursPris);

            $data['types'][$type['id']] = [
                'libelle' => $type['libelle'],
                'jours_attribues' => $joursAttribues,
                'jours_pris' => $joursPris,
                'jours_restants' => $joursRestants,
                'pourcentage_restant' => $joursAttribues > 0 ? round(($joursRestants / $joursAttribues) * 100, 2) : 0,
            ];

            if (str_contains(mb_strtolower($type['libelle']), 'annuel')) {
                $data['soldeAnnuel'] = [
                    'attribues' => $joursAttribues,
                    'pris' => $joursPris,
                    'restants' => $joursRestants,
                ];
            }
        }

        $data['activeMenu'] = 'dashboard';
        $data['listeDemande'] = $this->congesModel->getAllConges($userId);

        return view('Employe/dashboard', $data);
    }

    public function demandes(): string
    {
        return view('Employe/index', ['activeMenu' => 'demandes']);
    }

    public function nouvelleDemande(): string
    {
        $data['activeMenu'] = 'nouvelle';
        $data['listeType'] = $this->typeCongesModel->findAll();
        return view('Employe/create', $data);
    }
}