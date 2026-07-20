<?php

namespace App\Models;

use CodeIgniter\Model;

class TransfertModel extends Model
{
    protected $table = 'transferts';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'transaction_id',
        'client_destinataire_id'
    ];
}