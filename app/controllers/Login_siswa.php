<?php

class Login_siswa extends Controllers{
    public function index()
    {
        $this->view('login_siswa/index');
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $siswa = $this->model('User_model')->getUserByUsername($username);

        if ($siswa && password_verify($password, $siswa['password'])) {
            // Simpan data ke session
            $_SESSION['user'] = [
                'id_siswa' => $siswa['id_siswa'],
                'nama' => $siswa['nama'],
                'role' => 'siswa'
            ];

            
            
            header("Location: " . BASEURL . "/dashboard");
            exit;
        } else {
            echo "Username atau password salah!";
        }
    }

}