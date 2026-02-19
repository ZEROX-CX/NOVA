<?php 

class Prog extends Controllers {
    public function index()
    {
        // Jika session ada, lanjutkan proses
        $id_siswa = $_SESSION['id_siswa'];
        $summary = $this->model('Progress_model')->getSummary($id_siswa);
        $data['progress'] = $this->model('Progress_model')->getProgressBySiswa($id_siswa);
        $total_absen = $this->model('Progress_model')->countAbsenBySiswa($id_siswa);

        $data['id_siswa'] = $id_siswa; // Kirim juga ID ke view
        if ($total_absen >= 2) {
            $data['teks'] = 'Anda sudah absen sebanyak ' . $total_absen . ' kali';
        } else {
            $data['teks'] = 'tidak ada data atau absen kurang dari 2 kali';
        }
        $this->view('prog/index', $data);
    }

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

        $this->model('Progress_model')->saveProgress($data);
        echo json_encode(['success' => true]);
    }
}