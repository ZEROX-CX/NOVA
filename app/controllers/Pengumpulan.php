<?php 

class Pengumpulan extends Controllers {
    
    public function index($id_tugas, $id_pertemuan)
    {
        // Ambil data tugas
        $tugas = $this->model('Tugas_model')->getTugasById($id_tugas);

        $id_siswa = $_SESSION['id_siswa'];

        // Cek apakah siswa sudah pernah mengumpulkan tugas ini
        $pengumpulan = $this->model('Pengumpulan_model')->getPengumpulanBySiswaDanTugas($id_siswa, $id_tugas);
        $data['waktu'] = $this->model('Tugas_model')->getTugas($id_tugas);
        
        // --- LOGIKA UNTUK PESAN YANG TETAP ADA (BERDASARKAN ID TUGAS) ---
        $message_key = 'submission_message_' . $id_tugas;
        $status_key = 'submission_status_' . $id_tugas;

        // Ambil pesan untuk tugas ini jika ada
        $data['submission_message'] = $_SESSION[$message_key] ?? null;
        $data['submission_status'] = $_SESSION[$status_key] ?? null;
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);

        // Hapus pesan untuk tugas LAIN (bersihkan session dari tugas lama)
        foreach ($_SESSION as $key => $value) {
            if (strpos($key, 'submission_message_') !== false && $key !== $message_key) {
                unset($_SESSION[$key]);
                unset($_SESSION[str_replace('message', 'status', $key)]);
            }
        }
        // --- AKHIR LOGIKA PESAN ---

        // --- LOGIKA UNTUK MENENTUKAN APAKAH BOLEH MENGUMPULKAN ---
        $boleh_kumpul = false;
        $deadline_passed = false;
        
        // Cek deadline
        $deadline = !empty($tugas['deadline']) ? new DateTime($tugas['deadline']) : null;
        $waktu_sekarang = new DateTime();
        
        // Cek apakah deadline sudah lewat
        if ($deadline && $waktu_sekarang > $deadline) {
            $deadline_passed = true;
        }

        // Boleh mengumpulkan jika:
        // 1. Deadline belum lewat
        // 2. Atau jika deadline sudah lewat TAPI allow_late = true
        if (($deadline && $waktu_sekarang < $deadline) || 
            ($deadline_passed && isset($tugas['allow_late']) && $tugas['allow_late'] == 1)) {
            $boleh_kumpul = true;
        }
        
        // Jika sudah ada pengumpulan, cek apakah boleh edit
        if ($pengumpulan) {
            // Boleh edit jika:
            // 1. Deadline belum lewat
            // 2. Atau jika deadline sudah lewat TAPI allow_late = true
            if (($deadline && $waktu_sekarang < $deadline) || 
                ($deadline_passed && isset($tugas['allow_late']) && $tugas['allow_late'] == 1)) {
                $boleh_kumpul = true;
            } else {
                $boleh_kumpul = false;
            }
        }
        // --- AKHIR LOGIKA MENGUMPULKAN ---

        // Kirim semua data ke view
        $data['id_tugas'] = $id_tugas;
        $data['tugas'] = $tugas;
        $data['pengumpulan'] = $pengumpulan;
        $data['boleh_kumpul'] = $boleh_kumpul;
        $data['deadline_passed'] = $deadline_passed;

        $this->view('pengumpulan/index', $data);
    }

public function kumpul()
{
    // Set header JSON di awal method
    header('Content-Type: application/json');
    $id_siswa = $_SESSION['id_siswa'] ?? null;
    $id_tugas = $_POST['id_tugas'] ?? null;

    try {
        // Ambil data tugas
        $tugas = $this->model('Tugas_model')->getTugasById($id_tugas);
        if (!$tugas) {
            echo json_encode(['success' => false, 'error' => 'Data tugas tidak ditemukan.']);
            exit;
        }
        // DEBUG: Log data tugas yang diambil dari database
        // Ini akan membantu kita melihat apakah 'deadline' dan 'allow_late' terbaca dengan benar
        error_log("PENGUMPULAN DEBUG: Data Tugas untuk ID $id_tugas: " . print_r($tugas, true));

        // Ambil dan pastikan nilai allow_late ada, default ke false jika tidak ada
        $allow_late = isset($tugas['allow_late']) ? (bool)$tugas['allow_late'] : false;

        // Cek deadline
        $deadline = !empty($tugas['deadline']) ? new DateTime($tugas['deadline']) : null;
        $waktu_sekarang = new DateTime();
        $deadline_passed = ($deadline && $waktu_sekarang > $deadline);

        // DEBUG: Log variabel penting untuk pengecekan deadline
        error_log("PENGUMPULAN DEBUG: Waktu Sekarang: " . $waktu_sekarang->format('Y-m-d H:i:s'));
        if ($deadline) {
            error_log("PENGUMPULAN DEBUG: Deadline Tugas: " . $deadline->format('Y-m-d H:i:s'));
        } else {
            error_log("PENGUMPULAN DEBUG: Deadline Tugas tidak diatur atau kosong.");
        }
        error_log("PENGUMPULAN DEBUG: Apakah Deadline Sudah Lewat? " . ($deadline_passed ? 'YA' : 'TIDAK'));
        error_log("PENGUMPULAN DEBUG: Apakah Pengumpulan Terlambat Diizinkan (Allow Late)? " . ($allow_late ? 'YA' : 'TIDAK'));

        // LOGIKA UTAMA: CEK DEADLINE
        // JIKA DEADLINE SUDAH LEWAT DAN PENGUMPULAN TERLAMBAT TIDAK DIIZINKAN, maka TOLAK.
        if ($deadline_passed && !$allow_late) {
            error_log("PENGUMPULAN DEBUG: UPLOAD DITOLAK. Alasan: Deadline sudah lewat dan allow_late tidak aktif.");
            echo json_encode(['success' => false, 'error' => 'Deadline telah lewat dan pengumpulan terlambat tidak diizinkan.']);
            exit;
        }

        // Jika lolos pengecekan di atas, lanjutkan proses upload file
        if (isset($_FILES['file_jawaban']) && $_FILES['file_jawaban']['error'] === UPLOAD_ERR_OK) {
            // ... (Kode untuk proses upload file tetap sama seperti sebelumnya) ...
            $file = $_FILES['file_jawaban'];
            $fileName = $file['name'];
            $fileTmpPath = $file['tmp_name'];
            $fileSize = $file['size'];
            
            // Validasi ukuran file
            if ($fileSize > 10 * 1024 * 1024) {
                echo json_encode(['success' => false, 'error' => 'Ukuran file terlalu besar. Maksimal 10MB.']);
                exit;
            }
            
            // Validasi ekstensi file
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'zip', 'rar'];
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                echo json_encode(['success' => false, 'error' => 'Format file tidak diizinkan.']);
                exit;
            }
            
            // Siapkan direktori upload
            $uploadDir = __DIR__ . '/../../public/uploads/tugas/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generate nama file unik
            $newFileName = uniqid('tugas_', true) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;

            // Pindahkan file
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Tentukan status pengumpulan
                $status_kumpul = 'tepat waktu'; 
                $is_late = 0;
                
                if ($deadline) {
                    if ($waktu_sekarang < $deadline) { 
                        $status_kumpul = 'lebih awal'; 
                        $is_late = 0; 
                    }
                    elseif ($waktu_sekarang > $deadline) { 
                        $status_kumpul = 'telat'; 
                        $is_late = 1; 
                    }
                }

                // Simpan ke database
                $db_ok = false;
                $pengumpulanModel = $this->model('Pengumpulan_model');
                $pengumpulan_lama = $pengumpulanModel->getPengumpulanBySiswaDanTugas($id_siswa, $id_tugas);
                $is_edit = !empty($pengumpulan_lama);

                if ($is_edit) {
                    $oldFilePath = $uploadDir . $pengumpulan_lama['file_jawaban'];
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                    $db_ok = $pengumpulanModel->editPengumpulan($id_siswa, $id_tugas, [
                        'file_jawaban' => $newFileName,
                        'is_late' => $is_late
                    ]);
                    $pesan_aksi = "diperbarui";
                } else {
                    $db_ok = $pengumpulanModel->kumpulTugas($id_tugas, [
                        'file_jawaban' => $newFileName,
                        'is_late' => $is_late
                    ], $id_siswa);
                    $pesan_aksi = "dikumpulkan";
                }

                if (!$db_ok) {
                    if (file_exists($destPath)) {
                        unlink($destPath);
                    }
                    echo json_encode(['success' => false, 'error' => 'Gagal menyimpan data ke database.']);
                    exit;
                }

                $message_key = 'submission_message_' . $id_tugas;
                $_SESSION[$message_key] = "Tugas berhasil <strong>" . $pesan_aksi . "</strong> dengan status: <strong>" . ucfirst($status_kumpul) . "</strong>";

                echo json_encode(['success' => true, 'redirect' => true]);
                exit;
            } else {
                echo json_encode(['success' => false, 'error' => 'Gagal mengupload file.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Tidak ada file yang diupload atau terjadi kesalahan.']);
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        exit;
    }

    if (isset($_SESSION['id_siswa'])) {

        $id_siswa = $_SESSION['id_siswa'];
        $progress = $this->model('Progress_model');

        $progress->updateProgress([
            'id_siswa'       => $id_siswa,
            'id_pertemuan'   => $id_pertemuan,
            'tipe_aktivitas' => 'tugas',
            'status'         => 'sedang_dikerjakan',      // karena baru dibuka
            'progress_percentage' => 50                   // progress materi → 50%
        ]);
    }
}

// Di dalam file app/controllers/Pengumpulan.php

public function list($id_pertemuan)
{
    // 1. Ambil data pertemuan untuk mendapatkan id_mapel
    $pertemuan = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
    
    // Cek jika pertemuan tidak ditemukan
    if (!$pertemuan) {
        // Anda bisa redirect ke halaman error atau tampilkan pesan
        die('Data pertemuan tidak ditemukan.');
    }
    $id_mapel = $pertemuan['id_mapel'];

    // 2. Ambil SEMUA siswa yang terdaftar di mapel tersebut
    $siswa_list = $this->model('Siswa_model')->getSiswaByMapel($id_mapel);

    // 3. Ambil data tugas untuk pertemuan ini
    $tugas_pertemuan = $this->model('Tugas_model')->getTugasByPertemuan($id_pertemuan);
    
    // 4. Jika ada tugas, kumpulkan semua data pengumpulan tugas siswa dalam satu array
    $pengumpulan_map = []; // Gunakan map (array asosiatif) untuk pencarian yang lebih cepat
    if (!empty($tugas_pertemuan)) {
        foreach ($tugas_pertemuan as $tugas) {
            $pengumpulan_tugas = $this->model('Pengumpulan_model')->getPengumpulanByTugas($tugas['id_tugas']);
            if (!empty($pengumpulan_tugas)) {
                foreach ($pengumpulan_tugas as $p) {
                    // Gunakan id_siswa sebagai KEY
                    $pengumpulan_map[$p['id_siswa']] = $p;
                }
            }
        }
    }
    
    // 5. Gabungkan data siswa dengan data pengumpulan
    if (!empty($siswa_list)) {
        foreach ($siswa_list as &$siswa) {
            // Cek apakah siswa ini ada di peta pengumpulan
            if (isset($pengumpulan_map[$siswa['id_siswa']])) {
                $siswa['file_jawaban'] = $pengumpulan_map[$siswa['id_siswa']]['file_jawaban'];
                $siswa['tanggal_kumpul'] = $pengumpulan_map[$siswa['id_siswa']]['tanggal_kumpul'];
                $siswa['is_late'] = $pengumpulan_map[$siswa['id_siswa']]['is_late'];
            } else {
                // Jika tidak ada, beri nilai default
                $siswa['file_jawaban'] = null;
                $siswa['tanggal_kumpul'] = null;
                $siswa['is_late'] = null;
            }
        }
    }

    $data['judul'] = 'File Tugas Siswa';
    $data['siswa'] = $siswa_list; // Mengirim data gabungan ke view
    $data['id_pertemuan'] = $id_pertemuan;

    $this->view('templates/navbar', $data);
    $this->view('pengumpulan/list', $data);
}

    // ======================================================
    // TAMBAHKAN METHOD DOWNLOAD INI
    // ======================================================
    public function download($filename)
    {
        // Direktori tempat file disimpan
        $file_path = __DIR__ . '/../../public/uploads/tugas/' . $filename;
        
        // Validasi: Pastikan file ada dan aman untuk diakses
        // basename() mencegah Path Traversal Attack
        if (file_exists($file_path) && $filename === basename($filename)) {
            
            // Set header untuk memaksa browser mendownload file
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            
            // Bersihkan output buffer sebelum membaca file
            ob_clean();
            flush();
            
            // Baca dan keluarkan isi file
            readfile($file_path);
            
            // Hentikan eksekusi script
            exit;
            
        } else {
            // Jika file tidak ditemukan, tampilkan halaman error 404
            // atau pesan kesalahan yang lebih aman
            http_response_code(404);
            // Anda bisa redirect ke halaman error 404 yang sudah Anda buat
            // $this->view('error/404'); 
            echo "File tidak ditemukan.";
            exit;
        }
    }
}