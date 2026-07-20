<?php



namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = session()->get('user');

        if ($user) {
            return redirect()->to($this->homeForRole($user['role']));
        }

        return view('login');
    }

    public function login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('erreur', 'Veuillez renseigner un email et un mot de passe valides.');
        }

        $user = $this->userModel->authenticate(
            (string) $this->request->getPost('email'),
            (string) $this->request->getPost('password')
        );

        if (!$user) {
            return redirect()->back()->withInput()->with('erreur', 'Email ou mot de passe incorrect, ou compte désactivé.');
        }

        unset($user['password']);
        session()->regenerate();
        session()->set('user', $user);
        session()->set('userId', $user['id']);

        return redirect()->to($this->homeForRole($user['role']));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('succes', 'Vous êtes maintenant déconnecté.');
    }

    private function homeForRole(string $role): string
    {
        return match ($role) {
            'admin' => '/admin',
            'rh' => '/rh',
            default => '/employe',
        };
    }
}
