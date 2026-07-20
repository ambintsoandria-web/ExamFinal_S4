<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionsModel extends Model
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
    public function getHistoriqueClient($idClient)
    {
        return $this->join('types_operations', 'transactions.type_operation_id = types_operations.id')
            ->where('transactions.client_id', $idClient)->findAll();
    }
}
