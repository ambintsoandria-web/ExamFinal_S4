<?php

namespace App\Models;

use CodeIgniter\Model;

class CongesModel extends Model
{
    protected $table = 'conges';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'employee_id',
        'type_conge_id',
        'date_debut',
        'date_fin',
        'nb_jours',
        'motif',
        'statut',
        'commentaire_rh',
        'traite_par'
    ];

    public function getCount($empId, $statut)
    {
        return $this->where('employee_id', $empId)
            ->where('statut', $statut)
            ->countAllResults();
    }
    public function getSommeJours($empId, $typeId)
    {
        $result = $this->selectSum('nb_jours')
            ->where('employee_id', $empId)
            ->where('type_conge_id', $typeId)
            ->where('statut', 'approuvee')
            ->get()
            ->getRow();

        return $result ? (int) $result->nb_jours : 0;
    }
    public function getAllConges($userId)
    {
        return $this->select('conges.*, types_conge.libelle')
            ->where('conges.employee_id', $userId)
            ->join('types_conge', 'conges.type_conge_id = types_conge.id')
            ->orderBy('conges.created_at', 'DESC')
            ->findAll();
    }
    public function getDuree($debut, $fin)
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT calculerDureeJours(?, ?) as duree", [$debut, $fin]);
        return $query->getRow()->duree;
    }
    // public function getSoldeAnnuelTotal($idEmp)
    // {
    //     $res = $this->selectSum('nb_jours')->where('employee_id', $idEmp)->get()->getRow();
    //     return $res ? (int) $res->nb_jours : 0;
    // }
//     public function getSoldeAnnuelTotal($idEmp)
// {
//     $query = $this->db->query("SELECT SUM(jours_annuels) as total FROM types_conge WHERE id = ?", [$idEmp]);
//     $result = $query->getRow();
//     return $result ? (int)$result->total : 0;
// }
    public function getSoldeAnnuelTotal()
    {
        $query = $this->db->query("SELECT SUM(jours_annuels) as total FROM types_conge")->getRow();
        return $query ? (int) $query->total : 0;
    }
    // public function getSoldeAnnuelTotal()
    // {
    //     $result = $this->db->table('types_conge')
    //         ->selectSum('jours_annuels', 'total')
    //         ->get()
    //         ->getRow();

    //     return $result ? (int) $result->total : 0;
    // }
    public function getSommeSoldeUtilise($idEmp)
    {
        $result = $this->selectSum('nb_jours')->where('employee_id', $idEmp)->where('statut', 'approuvee')->get()->getRow();
        return $result ? (int) $result->nb_jours : 0;
    }
}
