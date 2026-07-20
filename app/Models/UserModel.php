<?php
namespace App\Models;

error_reporting(E_ALL);
ini_set('display_errors', 1);



use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'employes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'prenom', 'email', 'password', 'role', 'departement_id', 'date_embauche', 'actif'];
    protected $returnType = 'array';  // ou 'object'
    protected $useTimestamps = false;
    public function authenticate(string $email, string $password): array|false
    {
        $user = $this->where('email', strtolower(trim($email)))
            ->where('actif', 1)
            ->first();

        if (!$user) {
            return false;
        }

        $valid = password_verify($password, $user['password'])
            || hash_equals((string) $user['password'], $password);

        return $valid ? $user : false;
    }
    public function getRoles()
    {
        $query = $this->db->query("SELECT DISTINCT role FROM employes");
        return $query->getResultArray(); // équivalent à findAll()
    }
    // public function getRoles1(){
    //     return $this->select('role')->distinct()->findAll();
    // }
    // public function getRoles()
    // {
    //     return $this->select('role')
    //         ->groupBy('role')
    //         ->findAll();
    // }
    // public function getRoles()
    // {
    //     $query = $this->db->query("SELECT DISTINCT role FROM employes");
    //     $result = $query->getResultArray();
    //     return $result;
    // }
    public function getRolesQuery()
    {
        return $this->db->query("SELECT DISTINCT role FROM employes")->getResultArray();
    }
    public function getInitiales($nom, $prenom)
    {
        return strtoupper(substr($nom, 0, 1) . substr($prenom, 0, 1));
    }
    public function findAllEmp($departement = null, $search = null)
    {
        $builder = $this->db->table('employes');
        $builder->select('employes.*, departements.nom as departName');
        $builder->join('departements', 'departements.id = employes.departement_id', 'left');
        $builder->where('employes.actif', 1);

        if (!empty($departement)) {
            $builder->where('employes.departement_id', $departement);
        }

        if (!empty($search)) {
            $builder->groupStart()
                ->like('employes.nom', $search)
                ->orLike('employes.prenom', $search)
                ->orLike('employes.email', $search)
                ->groupEnd();
        }

        $query = $builder->get();
        return $query->getResultArray();
    }    
    // public function findAllEmp()
    // {
    //     $query = $this->db->query("SELECT *,departements.nom as departName FROM employes JOIN departements ON employes.departement_id = departements.id");
    //     return $query->getResultArray();
    // }
}



// // SELECT simple
// $query = $this->db->table('employes')
//                   ->select('id, nom, prenom, email, role')
//                   ->where('actif', 1)
//                   ->get();
// $result = $query->getResultArray();

// // SELECT avec DISTINCT
// $query = $this->db->table('employes')
//                   ->select('DISTINCT role')
//                   ->get();
// $result = $query->getResultArray();

// // SELECT avec COUNT
// $query = $this->db->table('employes')
//                   ->select('COUNT(*) as total')
//                   ->where('actif', 1)
//                   ->get();
// $total = $query->getRow()->total;

// // SELECT avec JOIN
// $query = $this->db->table('conges')
//                   ->select('conges.*, types_conge.libelle')
//                   ->join('types_conge', 'types_conge.id = conges.type_conge_id')
//                   ->where('conges.employee_id', $userId)
//                   ->get();
// $result = $query->getResultArray();

// // INSERT
// $this->db->table('employes')->insert([
//     'nom' => 'Rakoto',
//     'prenom' => 'Soa',
//     'email' => 'soa@techmada.mg'
// ]);

// // UPDATE
// $this->db->table('employes')
//          ->where('id', 1)
//          ->update(['actif' => 0]);

// // DELETE
// $this->db->table('employes')
//          ->where('id', 1)
//          ->delete();
// public function findAllEmp($search = null, $departement = null)
// {
//     $builder = $this->db->table('employes');
//     $builder->select('employes.*, departements.nom as departName');
//     $builder->join('departements', 'departements.id = employes.departement_id', 'left');

//     // Filtre recherche
//     if (!empty($search)) {
//         $builder->groupStart()
//             ->like('employes.nom', $search)
//             ->orLike('employes.prenom', $search)
//             ->orLike('employes.email', $search)
//             ->groupEnd();
//     }

//     // Filtre département
//     if (!empty($departement)) {
//         $builder->where('employes.departement_id', $departement);
//     }

//     $query = $builder->get();
//     return $query->getResultArray();
// }

// public function getRoles()
// {
//     return $this->db->table('roles')->get()->getResultArray();
// }
