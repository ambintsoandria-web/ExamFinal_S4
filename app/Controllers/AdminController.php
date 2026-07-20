<?php

namespace App\Controllers;

use App\Models\CongesModel;
use App\Models\UserModel;
use App\Models\TypeCongesModel;
use App\Models\DepartementModel;


class AdminController extends BaseController
{
    protected UserModel $userModel;
    protected CongesModel $congesModel;
    protected TypeCongesModel $typeCongesModel;
    protected DepartementModel $departementModel;

    protected $db;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->congesModel = new CongesModel();
        $this->typeCongesModel = new TypeCongesModel();
        $this->db = \Config\Database::connect();
        $this->departementModel = new DepartementModel();
    }
    public function addDepart()
    {
        $nom = $this->request->getPost('nom');
        $description = $this->request->getPost('description');
        $this->departementModel->insert([
            'nom' => $nom,
            'description' => $description
        ]);
        return redirect()->to('admin/departement');
    }
    public function addEmp()
    {
        $nom = $this->request->getPost('nom');
        $prenom = $this->request->getPost('prenom');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $roleId = $this->request->getPost('roleId');
        $departementId = $this->request->getPost('departementId');
        $dateEmbauche = $this->request->getPost('dateEmbauche');
        $this->userModel->insert([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $password,
            'role' => $roleId,
            'departement_id' => $departementId,
            'date_embauche' => $dateEmbauche,
            'actif' => 1
        ]);
        return redirect()->to('admin/employes');
    }
    public function deleteEmp()
    {
        $idEmp = $this->request->getPost('id');

        if (!$idEmp) {
            echo "error";
            return;
        }

        $db = \Config\Database::connect();

        try {
            $db->table('conges')->where('traite_par', $idEmp)->update(['traite_par' => null]);
            $this->congesModel->where('employee_id', $idEmp)->delete();
            $db->table('soldes')->where('employee_id', $idEmp)->delete();
            $this->userModel->where('id', $idEmp)->delete();

            echo "success";
        } catch (\Exception $e) {
            echo "error";
        }
    }
}
