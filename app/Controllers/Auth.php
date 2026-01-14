<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Kalau sudah login, lempar ke dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->getUserByUsername($username);

        if ($user) {
            // Cek apakah password cocok dengan hash di DB
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id'        => $user['id'],
                    'username'  => $user['username'],
                    'fullname'  => $user['fullname'],
                    'role'      => $user['role'],
                    'logged_in' => true,
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('error', 'Password Salah!');
                return redirect()->to('/');
            }
        } else {
            session()->setFlashdata('error', 'Username Tidak Ditemukan!');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}