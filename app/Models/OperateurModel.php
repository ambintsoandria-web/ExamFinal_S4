<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'email',
        'telephone',
        'nom',
        'mot_de_passe',
        'actif',
        'date_creation'
    ];
}