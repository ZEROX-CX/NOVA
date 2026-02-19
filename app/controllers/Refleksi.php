<?php

class Refleksi extends Controllers {
    public function index($id_materi, $id_pertemuan)
    {
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['refleksi'] = $this->model('Refleksi_model')->getRefleksiByPertemuan($id_pertemuan);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_materi);
        $data['id_mapel'] = $id_materi;
        $data['id_pertemuan'] = $id_pertemuan;
        
        // Ambil jawaban siswa jika sudah ada
        if (isset($_SESSION['id_siswa'])) {
            $data['jawaban_siswa'] = $this->model('Refleksi_model')->getJawabanBySiswaPertemuan($_SESSION['id_siswa'], $id_pertemuan);
        }
        
        $this->view("templates/navbar", $data);
        $this->view("refleksi/index", $data);
    }

    public function submit()
    {
        // Debug - Tampilkan data yang diterima
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        
        $id_mapel = $_POST['id_mapel'];
        $id_pertemuan = $_POST['id_pertemuan'];
        $id_siswa = $_SESSION['id_siswa'];
        $jawaban = $_POST['jawaban'];

        foreach ($jawaban as $id_refleksi => $jawab) {
            echo "Menyimpan jawaban untuk refleksi ID: " . $id_refleksi . "<br>";
            
            $result = $this->model('Refleksi_model')->simpanJawaban(
                $id_siswa,
                $id_pertemuan,
                $jawab,
                $id_refleksi
            );
            
            if (!$result) {
                echo "Gagal menyimpan jawaban untuk refleksi ID: " . $id_refleksi . "<br>";
            }
        }
        
        // Redirect ke halaman sukses atau kembali ke halaman refleksi
        header('Location: ' . BASEURL . '/pertemuan_content/' . $id_mapel . '/' . $id_pertemuan);
        exit;
    }

    public function jawaban($id_pertemuan)
    {
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['jawaban'] = $this->model('Refleksi_model')->getJawabanBySiswaPertemuan($_SESSION['id_siswa'], $id_pertemuan);
        $this->view('refleksi/jawaban', $data);
    }
}