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
}