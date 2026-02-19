<?php

class ProgressController extends Controllers
{
    private $progressModel;

    public function __construct()
    {
        // Sesuaikan cara load model dengan framework Nova kamu
        $this->progressModel = $this->model('ProgressModel');
    }

    // Halaman untuk lihat progress satu siswa
    public function index()
    {
        // Pastikan session dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Periksa apakah id_siswa ada di session
        if (!isset($_SESSION['id_siswa'])) {
            // Redirect ke halaman login atau tampilkan pesan error
            header("Location: " . BASEURL . '/login');
            exit;
        }
        
        $id_siswa = $_SESSION['id_siswa'];
        $data['progress'] = $this->progressModel->getProgressBySiswa($id_siswa);
        $data['summary']  = $this->progressModel->getSummary($id_siswa);
        $data['id_siswa'] = $id_siswa;

        $this->view('templates/navbar', $data);
        $this->view('progress/index', $data);
    }

    // Endpoint untuk dicall dari controller lain (Ajax / form)
    public function record()
    {
        // Sesuaikan dengan method request di framework kamu
        $id_siswa   = $_POST['id_siswa'] ?? null;
        $tipe       = $_POST['tipe_aktivitas'] ?? null;

        if (!$id_siswa || !$tipe) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'id_siswa dan tipe_aktivitas wajib diisi']);
            return;
        }

        $data = [
            'id_siswa'  => $id_siswa,
            'id_pertemuan' => $_POST['id_pertemuan'] ?? null,
            'id_materi' => $_POST['id_materi'] ?? null,
            'id_tugas'  => $_POST['id_tugas'] ?? null,
            'id_game'   => $_POST['id_game'] ?? null,
            'tipe_aktivitas' => $tipe,
            'status'    => $_POST['status'] ?? 'selesai',
            'progress_percentage' => $_POST['progress_percentage'] ?? 100,
            'waktu_mulai' => $_POST['waktu_mulai'] ?? null,
            'waktu_selesai' => $_POST['waktu_selesai'] ?? date('Y-m-d H:i:s'),
            'durasi_pengerjaan' => $_POST['durasi_pengerjaan'] ?? null,
            'skor'      => $_POST['skor'] ?? null,
        ];

        $this->progressModel->saveProgress($data);

        echo json_encode(['success' => true]);
    }
}