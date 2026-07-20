<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'client_id',
        'type_operation_id',
        'montant',
        'frais',
        'date_transaction'
    ];

    public function getSommeTotalGains($date){
        return $this->selectSum('frais')
            ->where('date_transaction <', $date)
            ->first();
    }
    public function getSommeTotalGainsByTypeOperation($typeOperationId, $date){
        return $this->selectSum('frais')
            ->where('type_operation_id', $typeOperationId)
            ->where('date_transaction <', $date)
            ->first();
    }
    public function getSoldeTotalByClient($clientId, $date){
        return $this->selectSum('montant + frais as solde_total')
            ->where('client_id', $clientId)
            ->where('date_transaction <', $date)
            ->first();
    }

}