<?php

class Tugas extends Controllers {
    public function index($id_mapel, $id)
    {
        // Coba ambil sebagai id_tugas
        $tugas = $this->model('Tugas_model')->getTugasById($id);
        if ($tugas) {
            $id_pertemuan = $tugas['id_pertemuan'];
        } else {
            // Asumsikan $id adalah id_pertemuan
            $id_pertemuan = $id;
        }
        
        $data['tugas'] = $this->model('Pertemuan_model')->getTugasByPertemuan($id_pertemuan);
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;

        if (isset($_SESSION['id_siswa'])) {

            $id_siswa = $_SESSION['id_siswa'];
            $progress = $this->model('Progress_model');

            $progress->saveProgress([
                'id_siswa'       => $id_siswa,
                'id_pertemuan'   => $id_pertemuan,
                'tipe_aktivitas' => 'tugas',
                'status'         => 'sedang_dikerjakan',      // karena baru dibuka
                'progress_percentage' => 50                   // progress materi → 50%
            ]);
        }

        $this->view("templates/navbar", $data);
        $this->view("tugas/index", $data);
    }

    // 🔹 METHOD TAMBAH TUGAS
    public function tambah($id_materi = null)
    {
        include "../service/database.php";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $judul_tugas = $_POST['judul_tugas'];
            $deskripsi = $_POST['deskripsi'];
            $file_name = null;

            // Upload file
            if (!empty($_FILES['file_tugas']['name'])) {
                $file_name = time() . "_" . basename($_FILES['file_tugas']['name']);
                move_uploaded_file($_FILES['file_tugas']['tmp_name'], "../uploads/" . $file_name);
            }

            mysqli_query($db, "INSERT INTO tugas (id_materi, judul_tugas, deskripsi, file_tugas)
                               VALUES ('$id_materi', '$judul_tugas', '$deskripsi', '$file_name')");

            header("Location: " . BASEURL . "/tugas/index/$id_materi");
            exit;
        }

        $data = ['id_materi' => $id_materi];
        $this->view("tugas/tambah_tugas", $data);
    }

    public function edit($id_mapel, $id_pertemuan)
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }
        
        // Langsung ambil data tugas berdasarkan id_pertemuan
        $data['tugas'] = $this->model('Tugas_model')->getTugasByPertemuan($id_pertemuan);
        
        // getTugasByPertemuan() mengembalikan array, kita ambil elemen pertama
        if (empty($data['tugas'])) {
            die('Tugas untuk pertemuan ini tidak ditemukan.');
        }
        $data['tugas'] = $data['tugas'][0]; // Ambil data tugas dari array

        $data['id_mapel'] = $id_mapel;
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        
        $this->view("templates/navbar", $data);
        $this->view("tugas/edit", $data);
    }

    // --- METHOD UPDATE YANG DIPERMUDAH ---
    public function update()
    {
        if (!isset($_SESSION['id_guru']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $id_pertemuan = $_POST['id_pertemuan'];
        $id_mapel = $_POST['id_mapel'];
        $file_lama = $_POST['file_lama'];
        $file_tugas_baru = null;

        // Handle file upload (logikanya sama)
        if (isset($_FILES['file_tugas']) && $_FILES['file_tugas']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['file_tugas'];
            $file_tugas_baru = time() . '_' . basename($file['name']);
            move_uploaded_file($file['tmp_name'], 'uploads/' . $file_tugas_baru);

            if (!empty($file_lama) && file_exists('uploads/' . $file_lama)) {
                unlink('uploads/' . $file_lama);
            }
        }

        $data = [
            'judul_tugas' => $_POST['judul_tugas'],
            'deskripsi' => $_POST['deskripsi'],
            'deadline' => $_POST['deadline'] ?: null,
            'allow_late' => isset($_POST['allow_late']) ? 1 : 0
        ];

        // 🔹 PERUBAHAN: Langsung panggil model dengan id_pertemuan
        $this->model('Tugas_model')->updateTugas($id_pertemuan, $data, $file_tugas_baru);
        
        header("Location: " . BASEURL . "/guru/tugas/" . $id_mapel . "/" . $id_pertemuan);
        exit;
    }
}