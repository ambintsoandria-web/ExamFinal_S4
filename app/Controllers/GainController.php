<?php
    namespace App\Controllers;

    public class GainController extends BaseController
    {
        public $transactionModel;
        public $fraisModel;
        public $typeOperationModel;

        public function __construct()
        {
            $this->transactionModel = new \App\Models\TransactionModel();
            $this->fraisModel = new \App\Models\FraisModel();
            $this->typeOperationModel = new \App\Models\TypeOperationModel();
        }
        public function index()
        {
            $date = date('Y-m-d H:i:s');
            $totalGains = $this->transactionModel->getSommeTotalGains($date);

            $typeOperations = $this->typeOperationModel->findAll();
            $gainsByTypeOperation = [];

            foreach ($typeOperations as $typeOperation) {
                $gainsByTypeOperation[$typeOperation['nom']] = $this->transactionModel->getSommeTotalGainsByTypeOperation($typeOperation['id'], $date);
            }

            return view('gain/index', [
                'totalGains' => $totalGains,
                'gainsByTypeOperation' => $gainsByTypeOperation
            ]);
        }
    }
?>