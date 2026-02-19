<?php

class Absen extends Controllers {

    public function index($id_mapel, $id_pertemuan)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_siswa = $_SESSION['id_siswa'] ?? null;

        if (!$id_siswa) {
            $_SESSION['flash_message'] = "Anda harus login sebagai siswa untuk melihat absensi.";
            $_SESSION['message_type'] = 'error';
            header("Location: " . BASEURL . "/login_siswa");
            exit;
        }

        // Jika siswa sudah absen, jangan tampilkan form — arahkan kembali
        $already = $this->model('Absen_model')->cekKehadiran($id_pertemuan, $id_siswa);
        if ($already) {
            $_SESSION['flash_message'] = "⚠️ Anda sudah melakukan absensi untuk pertemuan ini.";
            $_SESSION['message_type'] = 'error';
            $pertemuan = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
            $id_materi = $pertemuan['id_mapel'] ?? '';
            header("Location: " . BASEURL . '/pertemuan_content/' . $id_materi . '/' . $id_pertemuan);
            exit;
        }

        $sesi_absen = $this->model('Pertemuan_model')->getSesiByPertemuan($id_pertemuan);
        $pertemuan = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        if (!$pertemuan) {
            // Debug: Tampilkan langsung di layar
            echo "<h2 style='color:red; text-align:center; margin-top:50px;'>❌ Pertemuan dengan ID <strong>" . htmlspecialchars($id_pertemuan) . "</strong> tidak ditemukan.</h2>";
            echo "<p style='text-align:center;'>Silakan periksa kembali URL atau hubungi administrator.</p>";
            exit;
        }

        $data['id_pertemuan'] = $id_pertemuan;
        $data['id_mapel'] = $id_mapel;
        $data['judul'] = "Absen";
        $data['pertemuan'] = $pertemuan;
        $data['sesi_absen'] = $sesi_absen;
        $this->view('templates/navbar', $data);
        $this->view('absen/index', $data);
    }

    public function list($id_mapel, $id_pertemuan)
    {
        $absen = $this->model('Absen_model')->getAbsenByPertemuan($id_pertemuan);

        $data['judul'] = 'Daftar Hadir';
        $data['siswa'] = $absen;
        $data['id_pertemuan'] = $id_pertemuan; // Tambahkan ID pertemuan ke data
        $data['id_mapel'] = $id_mapel;

        $this->view('templates/navbar', $data);
        $this->view('absen/list', $data);
    }

    public function tambah($id_pertemuan)
    {
        $pertemuan = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);

        $id_materi = $pertemuan['id_mapel'];
        $id_siswa  = $_SESSION['id_siswa'] ?? null;

        // Ambil dan sanitasi input status/keterangan
        $post = [];
        $post['status'] = isset($_POST['status']) ? trim($_POST['status']) : null;
        $post['keterangan'] = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

        // Cek apakah siswa sudah melakukan absensi untuk pertemuan ini
        $already = $this->model('Absen_model')->cekKehadiran($id_pertemuan, $id_siswa);
        if ($already) {
            $_SESSION['message_type'] = 'error';
            header("Location: " . BASEURL . '/pertemuan_content/' . $id_materi . '/' . $id_pertemuan);
            exit;
        }

        if (empty($post['status'])) {
            $_SESSION['flash_message'] = "Silakan pilih status kehadiran.";
            header("Location: " . BASEURL . '/pertemuan_content/' . $id_materi . '/' . $id_pertemuan);
            exit;
        }

        $inserted = $this->model('Absen_model')->insertIntoAbsen($id_pertemuan, $id_siswa, $post);
        $total_absen = $this->model('Progress_model')->countAbsenBySiswa($id_siswa);
        if($total_absen == 3) {
            // $this->model('Achievement_model')->unlockAchievementAbsen($id_siswa, 'Siswa_teladan');
        }
        $progress = $this->model('Progress_model');  // load model

        $progress->saveProgress([
            'id_siswa'       => $id_siswa,
            'id_pertemuan'   => $id_pertemuan,
            'tipe_aktivitas' => 'absen',
            'status'         => 'selesai',
            'progress_percentage' => 100
        ]);
        if ($inserted) {
            $_SESSION['flash_message'] = "✅ Absensi berhasil dilakukan! Silahkan pergi ke halaman sebelumnya.";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = "❌ Gagal menyimpan absensi. Silakan coba lagi atau hubungi admin. (Error: Sesi tidak dapat dibuat atau data tidak tersimpan)";
            $_SESSION['message_type'] = 'error';
        }

        header("Location: " . BASEURL . '/pertemuan_content/' . $id_materi . '/' . $id_pertemuan);
        exit;
    }

    // Fungsi baru untuk mengedit tanggal sesi absen
    public function editTanggal($id_pertemuan)
    {
        // Set header untuk response JSON
        header('Content-Type: application/json');
        
        // Siapkan array untuk menyimpan informasi debug
        $debug = [];
        $debug['id_pertemuan_diterima'] = $id_pertemuan;
        
        // Validasi input
        if (empty($_POST['tanggal'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Tanggal tidak boleh kosong',
                'debug' => $debug
            ]);
            return;
        }
        
        // Validasi format tanggal
        $tanggal = $_POST['tanggal'];
        if (!DateTime::createFromFormat('Y-m-d', $tanggal)) {
            echo json_encode([
                'success' => false,
                'message' => 'Format tanggal tidak valid',
                'debug' => $debug
            ]);
            return;
        }
        
        // Cek apakah pertemuan ada
        $pertemuan = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $debug['hasil_query_pertemuan'] = $pertemuan; // Simpan hasil query ke debug
        
        if (!$pertemuan) {
            echo json_encode([
                'success' => false,
                'message' => 'Pertemuan tidak ditemukan dengan ID: ' . $id_pertemuan,
                'debug' => $debug // Kirim info debug ke browser
            ]);
            return;
        }
        
        // Update tanggal sesi absen
        $result = $this->model('Absen_model')->editAbsen($id_pertemuan, $tanggal);
        $debug['hasil_update_sesi'] = $result; // Simpan hasil update ke debug
        
        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Tanggal berhasil diperbarui',
                'debug' => $debug // Kirim info debug ke browser
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Gagal memperbarui tanggal. Mungkin tidak ada sesi absen yang terkait dengan pertemuan ini.',
                'debug' => $debug // Kirim info debug ke browser
            ]);
        }
    }
}