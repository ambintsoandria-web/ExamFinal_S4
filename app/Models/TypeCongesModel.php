<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongesModel extends Model
{
    protected $table = 'types_conge';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'libelle',
        'jours_annuels',
        'deductible',
    ];
    protected $returnType = 'array';
}