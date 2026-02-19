<?php

class Profil extends Controllers {
    public function index()
    {
        $data['kelas'] =  $this->model('Profil_model')->getKelasBySiswa();
        $data['judul'] = 'Profil';
        $data['jenis_kelamin'] = $this->model('Profil_model')->getKelaminBySiswa();
        $data['tanggal_daftar'] = $this->model('Profil_model')->getTanggalDaftar();
        $data['tanggal_daftar_guru'] = $this->model('Profil_model')->getTanggalDaftarGuru();
        $this->view('templates/navbar', $data);
        $this->view('profil/index', $data);
    }

    public function gantiProfil()
    {
        // Periksa apakah ada file yang diupload
        if (!empty($_FILES['gantiProfil']['name'])) {
            
            if (isset($_SESSION['role']) && $_SESSION['role'] == 'siswa') {
                $data = [
                    'file' => $_FILES['gantiProfil'],
                    'id_siswa' => $_SESSION['id_siswa']
                ];
                $this->model('Profil_model')->gantiProfil($data);
                $_SESSION['toast'] = [
                    'type' => 'success',
                    'message' => 'Foto Profil berhasil diganti'
                ];

            } elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'guru') {
                $data = [
                    'file' => $_FILES['gantiProfil'],
                    'id_guru' => $_SESSION['id_guru']
                ];
                $this->model('Profil_model')->gantiProfilGuru($data);
            }
        }

        // Redirect kembali ke halaman profil
        header("Location: " . BASEURL . "/profil");
        exit;
    }
}