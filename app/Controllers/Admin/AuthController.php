<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('admin/login', ['title' => 'Login Admin']);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user      = $userModel->where('username', $username)->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        session()->set([
            'isLoggedIn' => true,
            'user_id'    => $user['id'],
            'username'   => $user['username'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
