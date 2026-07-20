<?php

namespace App\Controllers;
use App\Models\FraisModel;
use App\Models\TypeOperations;
class FraisController extends BaseController
{
    public $fraisModel;
    public $typeOperationsModel;

    public function __construct()
    {
        $this->fraisModel = new FraisModel();
        $this->typeOperationsModel = new TypeOperations();
    }
    public function index(){
        $types_operations = $this->typeOperationsModel->findAll();

        $data = [];

        foreach ($types_operations as $type_operation) {
            $frais = $this->fraisModel->getFraisByTypeOperation($type_operation['id']);
            $data[] = [
                'type_operation' => $type_operation,
                'frais' => $frais
            ];
        }
        return view('Frais/index', ['data' => $data]);
    }
    public function create($typeOperationId)
    {
        return view('Frais/create', ['typeOperationId' => $typeOperationId]);
    }
    public function add()
    {
        $typeOperationId = $this->request->getPost('type_operation_id');
        $montantMin = $this->request->getPost('montant_min');
        $montantMax = $this->request->getPost('montant_max');
        $montantFrais = $this->request->getPost('montant_frais');

        $data = [
            'type_operation_id' => $typeOperationId,
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'montant_frais' => $montantFrais
        ];

        $this->fraisModel->insert($data);

        return redirect()->to(site_url('operateur/frais'));
    }
    public function edit($fraisId)
    {
        $frais = $this->fraisModel->getFraisById($fraisId);
        return view('Frais/modify', ['frais' => $frais]);
    }
    public function update($fraisId)
    {
        $montantMin = $this->request->getPost('montant_min');
        $montantMax = $this->request->getPost('montant_max');
        $montantFrais = $this->request->getPost('montant_frais');

        $data = [
            'montant_min' => $montantMin,
            'montant_max' => $montantMax,
            'montant_frais' => $montantFrais
        ];

        $this->fraisModel->updateFrais($fraisId, $data);

        return redirect()->to(site_url('operateur/frais'));
    }
    public function delete($fraisId)
    {
        $this->fraisModel->deleteFrais($fraisId);
        return redirect()->to(site_url('operateur/frais'));
    }
}