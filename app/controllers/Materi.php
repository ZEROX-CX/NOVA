<?php

class Materi extends Controllers {

    public function index($id_mapel, $id_pertemuan)
    {

        // Cek kehadiran siswa di pertemuan tersebut
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        // Ambil materi berdasarkan id_pertemuan
        $data['materi'] = $this->model('Materi_model')->getMateriByPertemuan($id_pertemuan);
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;
        
        // Inisialisasi variabel untuk mencegah error di view jika data tidak ada
        if (empty($data['materi'])) {
            $data['materi'] = ['isi_materi' => 'Materi untuk pertemuan ini belum tersedia.', 'file_materi' => null];
        }

        $this->view("templates/navbar", $data);
        $this->view("materi/index", $data);
    }

    public function streamPdf($id_materi)
    {
        // Pastikan hanya siswa yang sudah login yang bisa akses

        $materi = $this->model('Materi_model')->getMateriById($id_materi);

        if (!$materi || empty($materi['file_materi'])) {
            http_response_code(404);
            echo "File tidak ditemukan.";
            return;
        }

        $path = "uploads/materi/" . $materi['file_materi'];
        if (!file_exists($path)) {
            http_response_code(404);
            echo "File tidak ditemukan di server.";
            return;
        }

        // Set headers untuk PDF
        header("Content-Type: application/pdf");
        header("Content-Length: " . filesize($path));
        // Mencegah cache
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        // Buka file untuk dibaca
        readfile($path);
        exit;
    }

    public function download($id_materi)
    {
        // Pastikan hanya siswa yang sudah login yang bisa akses
        if (!isset($_SESSION['id_siswa'])) {
            echo "Akses ditolak.";
            return;
        }

        $id_siswa = $_SESSION['id_siswa'];

        // Validasi progres: hanya download jika sudah selesai membaca
        if (!$this->model('Materi_model')->hasCompletedTugas($id_siswa, $id_materi)) {
            // Anda bisa mengembalikan JSON untuk response AJAX
            http_response_code(403);
            echo "Anda harus menyelesaikan materi sebelum mengunduh.";
            return;
        }

        $materi = $this->model('Materi_model')->getMateriById($id_materi);
        if (!$materi || empty($materi['file_materi'])) {
            echo "File tidak ditemukan.";
            return;
        }

        $path = "uploads/materi/" . $materi['file_materi'];
        if (!file_exists($path)) {
            echo "File tidak ditemukan di server.";
            return;
        }

        // Set headers untuk download
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"" . basename($materi['file_materi']) . "\"");
        header("Content-Length: " . filesize($path));
        // Buka file untuk dibaca
        readfile($path);
        exit;
    }

    public function mark_read()
    {
        // Pastikan request adalah POST dan siswa sudah login
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['id_siswa'])) {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['status' => 'error', 'msg' => 'Metode request tidak valid.']);
            return;
        }

        $post = json_decode(file_get_contents("php://input"), true);

        $id_siswa = $_SESSION['id_siswa'];
        $id_materi = $post['id_tugas'] ?? null;

        if (!$id_materi) {
            http_response_code(400); // Bad Request
            echo json_encode(['status' => 'error', 'msg' => 'ID materi tidak dikirim.']);
            return;
        }

        // Cek apakah materi memang ada untuk siswa ini (opsional, tapi baik untuk keamanan)
        $materi = $this->model('Materi_model')->getMateriById($id_materi);
        if(!$materi) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'msg' => 'Materi tidak ditemukan.']);
            return;
        }

        if ($this->model('Materi_model')->markTugasCompleted($id_siswa, $id_materi)) {
            echo json_encode(['status' => 'ok', 'msg' => 'Progress berhasil disimpan.']);
        } else {
            echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan progress.']);
        }
    }

    public function edit($id_materi)
    {
        // Pastikan hanya guru yang bisa akses
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $data['judul'] = 'Edit Materi';
        $data['materi'] = $this->model('Materi_model')->getMateriById($id_materi);
        
        if (!$data['materi']) {
            // Handle kasus jika materi tidak ditemukan
            die('Materi tidak ditemukan.');
        }
        
        // Ambil data pertemuan juga untuk keperluan redirect
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($data['materi']['id_pertemuan']);

        $this->view("templates/navbar", $data);
        $this->view("materi/edit", $data);
    }

    public function update()
    {
        // Pastikan hanya guru yang bisa akses dan request adalah POST
        if (!isset($_SESSION['id_guru']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $id_materi = $_POST['id_materi'];
        $id_pertemuan = $_POST['id_pertemuan'];
        
        $data = [
            'isi_materi' => $_POST['isi_materi'],
            'link_youtube' => $_POST['link_youtube']
        ];

        // Logik untuk upload file bisa ditambahkan di sini
        // Contoh: if (isset($_FILES['file_materi']) && $_FILES['file_materi']['error'] === UPLOAD_ERR_OK) { ... }

        if ($this->model('Materi_model')->updateMateri($id_materi, $data)) {
            // Set pesan sukses (opsional)
            $_SESSION['flash'] = 'Materi berhasil diperbarui!';
        } else {
            // Set pesan error (opsional)
            $_SESSION['flash_error'] = 'Gagal memperbarui materi.';
        }

        header("Location: " . BASEURL . "/materi/index/" . $id_pertemuan);
        exit;
    }
}