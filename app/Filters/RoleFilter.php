<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $user = $session->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('erreur', 'Connectez-vous pour accéder à cette page.');
        }

        if (!in_array($user['role'] ?? '', $arguments ?? [], true)) {
            $home = match ($user['role'] ?? '') {
                'admin' => '/admin',
                'rh' => '/rh',
                'employe' => '/employe',
            };

            return redirect()->to($home)->with('erreur', 'Accès refusé : droits insuffisants.');
        }
    }
    public function after(
        RequestInterface $request,
        ResponseInterface
        $response,
        $arguments = null
    ) {
        // Rien à faire après
    }
}
