<?php

class Pertemuan_model {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // ============================================================
    // 🔹 METHOD GETTER (DIBUTUHKAN UNTUK MENAMPILKAN DATA)
    // ============================================================

    public function getPertemuanByMateri($id_materi) {
        $this->db->query("SELECT * FROM pertemuan WHERE id_mapel = :id_mapel ORDER BY tanggal ASC");
        $this->db->bind(':id_mapel', $id_materi);
        return $this->db->resultSet();
    }

    public function getPertemuanById($id) {
        // Debug: Tambahkan log untuk melihat ID yang dicari
        error_log("Mencari pertemuan dengan ID: " . $id);
        
        $this->db->query("SELECT * FROM pertemuan WHERE id_pertemuan = :id");
        $this->db->bind(':id', $id);
        
        // Debug: Tampilkan query yang dijalankan
        $query = "SELECT * FROM pertemuan WHERE id_pertemuan = :id";
        error_log("Query: " . $query);
        error_log("Parameter: " . $id);
        
        $result = $this->db->single();
        
        // Debug: Tampilkan hasil query
        error_log("Hasil query: " . ($result ? "Ditemukan" : "Tidak ditemukan"));
        
        return $result;
    }

    public function getMapel($id_mapel) {
        $this->db->query('SELECT * FROM mapel WHERE id_mapel=:id_mapel');
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->single();
    }

    /**
     * Mengambil data sesi absen berdasarkan ID pertemuan
     */
    public function getSesiByPertemuan($id_pertemuan) {
        $this->db->query("SELECT * FROM sesi_absen WHERE id_pertemuan = :id_pertemuan AND status = 'aktif'");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->single();
    }

    /**
     * Mengambil semua data pre-test berdasarkan ID pertemuan
     */
    public function getPretestById($id_pertemuan) {
        $this->db->query("SELECT * FROM pretest_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->execute();
        return $this->db->resultSet(); // Mengembalikan semua soal
    }

    /**
     * Mengambil semua data post-test berdasarkan ID pertemuan
     */
    public function getPosttestById($id_pertemuan) {
        $this->db->query("SELECT * FROM posttest_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->execute();
        return $this->db->resultSet(); // Mengembalikan semua soal
    }

    public function getRefleksiByPertemuan($id_pertemuan) 
    {
        $this->db->query('SELECT * FROM refleksi_pertemuan WHERE id_pertemuan=:id_pertemuan');
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    /**
     * Mengambil data materi berdasarkan ID pertemuan
     */
    public function getMateriByPertemuan($id_pertemuan) {
        $this->db->query("SELECT * FROM materi_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->single(); // 1 pertemuan biasanya hanya punya 1 materi
    }

    /**
     * Mengambil data tugas berdasarkan ID pertemuan
     */
    public function getTugasByPertemuan($id_pertemuan) {
        $this->db->query('SELECT * FROM tugas_pertemuan WHERE id_pertemuan = :id_pertemuan');
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->execute();
        return $this->db->single();
    }

    // ============================================================
    // 🔹 METHOD TAMBAH (SUDAH DIPERBAIKI)
    // ============================================================

    public function tambahPertemuan($data) {
        $query = "INSERT INTO pertemuan (id_mapel, judul_pertemuan, tanggal)
                  VALUES (:id_mapel, :judul_pertemuan, :tanggal)";
        $this->db->query($query);

        $this->db->bind(':id_mapel', (int)$data['id_mapel']);
        $this->db->bind(':judul_pertemuan', $data['judul_pertemuan']);

        // Tangani tanggal
        $tanggal = !empty($data['tanggal_sesi']) 
            ? date('Y-m-d', strtotime($data['tanggal_sesi']))
            : date('Y-m-d');
        $this->db->bind(':tanggal', $tanggal);

        $this->db->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Tambah Sesi Absen (VERSI LENGKAP & DIPERBAIKI)
     */
    public function tambahSesiAbsen($data) {
        try {
            if (empty($data['id_pertemuan'])) {
                throw new Exception("ID Pertemuan tidak boleh kosong");
            }

            // Cek apakah pertemuan ada
            $this->db->query("SELECT id_pertemuan FROM pertemuan WHERE id_pertemuan = :id");
            $this->db->bind(':id', $data['id_pertemuan']);
            $cek = $this->db->single();
            
            if (!$cek) {
                throw new Exception("Pertemuan dengan ID {$data['id_pertemuan']} tidak ditemukan");
            }

            // Buat kode sesi unik
            $prefix = "ABS";
            $date = date("Ymd");
            $randomNumber = mt_rand(100, 999);
            $kode_sesi = $prefix . "-" . $date . "-" . $randomNumber;

            // Siapkan data tanggal
            $tanggal_buat = null;
            if (!empty($data['tanggal_sesi'])) {
                $tanggal_input = trim($data['tanggal_sesi']);
                $tanggal_buat = date('Y-m-d H:i:s', strtotime($tanggal_input));
            }

            // Query INSERT
            if ($tanggal_buat) {
                $query = "INSERT INTO sesi_absen (id_pertemuan, kode_sesi, status, tanggal_buat)
                          VALUES (:id_pertemuan, :kode_sesi, :status, :tanggal_buat)";
            } else {
                $query = "INSERT INTO sesi_absen (id_pertemuan, kode_sesi, status)
                          VALUES (:id_pertemuan, :kode_sesi, :status)";
            }

            $this->db->query($query);
            $this->db->bind(':id_pertemuan', $data['id_pertemuan']);
            $this->db->bind(':kode_sesi', $kode_sesi);
            $this->db->bind(':status', 'aktif');
            
            if ($tanggal_buat) {
                $this->db->bind(':tanggal_buat', $tanggal_buat);
            }

            if (!$this->db->execute()) {
                $error = $this->db->getError();
                throw new Exception("Gagal menambahkan sesi absen: " . $error);
            }

            $lastId = $this->db->lastInsertId();
            
            if (!$lastId) {
                throw new Exception("Insert berhasil tapi tidak mendapatkan ID");
            }

            return $lastId;

        } catch (Exception $e) {
            error_log("ERROR tambahSesiAbsen: " . $e->getMessage());
            return false;
        }
    }

    public function tambahMultiplePreTest($data) {
        if (empty($data)) return 0;

        $query = "INSERT INTO pretest_pertemuan 
                 (id_pertemuan, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar)
                  VALUES (:id_pertemuan, :pertanyaan, :opsi_a, :opsi_b, :opsi_c, :opsi_d, :jawaban_benar)";
        
        $this->db->query($query);
        
        foreach ($data as $soal) {
            $this->db->bind(':id_pertemuan', $soal['id_pertemuan']);
            $this->db->bind(':pertanyaan', $soal['pertanyaan']);
            $this->db->bind(':opsi_a', $soal['opsi_a']);
            $this->db->bind(':opsi_b', $soal['opsi_b']);
            $this->db->bind(':opsi_c', $soal['opsi_c']);
            $this->db->bind(':opsi_d', $soal['opsi_d']);
            $this->db->bind(':jawaban_benar', $soal['jawaban_benar']);
            $this->db->execute();
        }
        
        return count($data);
    }

    public function tambahMultiplePostTest($data) {
        if (empty($data)) return 0;

        $query = "INSERT INTO posttest_pertemuan 
                 (id_pertemuan, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar)
                  VALUES (:id_pertemuan, :pertanyaan, :opsi_a, :opsi_b, :opsi_c, :opsi_d, :jawaban_benar)";
        
        $this->db->query($query);
        
        foreach ($data as $soal) {
            $this->db->bind(':id_pertemuan', $soal['id_pertemuan']);
            $this->db->bind(':pertanyaan', $soal['pertanyaan']);
            $this->db->bind(':opsi_a', $soal['opsi_a']);
            $this->db->bind(':opsi_b', $soal['opsi_b']);
            $this->db->bind(':opsi_c', $soal['opsi_c']);
            $this->db->bind(':opsi_d', $soal['opsi_d']);
            $this->db->bind(':jawaban_benar', $soal['jawaban_benar']);
            $this->db->execute();
        }
        
        return count($data);
    }

    public function tambahMultipleRefleksi($data) {
        if (empty($data)) return 0;

        $query = "INSERT INTO refleksi_pertemuan 
                 (id_pertemuan, pertanyaan)
                  VALUES (:id_pertemuan, :pertanyaan)";
        
        $this->db->query($query);
        
        foreach ($data as $soal) {
            $this->db->bind(':id_pertemuan', $soal['id_pertemuan']);
            $this->db->bind(':pertanyaan', $soal['pertanyaan']);
            $this->db->execute();
        }
        
        return count($data);
    }

    public function tambahMateri($data) {
        $fileName = null;
        if (!empty($data['file']['name'])) {
            $targetDir = __DIR__ . "/../../public/uploads/materi/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $fileName = time() . "_" . basename($data['file']['name']);
            move_uploaded_file($data['file']['tmp_name'], $targetDir . $fileName);
        }

        $textValue = $data['teks'] ?? '';
        $linkYoutube = $data['link_youtube'] ?? '';
        
        $query = "INSERT INTO materi_pertemuan (id_pertemuan, isi_materi, file_materi, link_youtube)
                VALUES (:id_pertemuan, :isi_materi, :file_materi, :link_youtube)";
        $this->db->query($query);
        $this->db->bind(':id_pertemuan', $data['id_pertemuan']);
        $this->db->bind(':isi_materi', $textValue);
        $this->db->bind(':file_materi', $fileName);
        $this->db->bind(':link_youtube', $linkYoutube);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function tambahTugas($data) {
        $fileName = null;

        if (!empty($data['file']['name'])) {
            $targetDir = __DIR__ . "/../../public/uploads/tugas/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $fileName = time() . "_" . basename($data['file']['name']);
            move_uploaded_file($data['file']['tmp_name'], $targetDir . $fileName);
        }

        $deskripsiValue = $data['teks'] ?? '';
        $deadline = !empty($data['deadline']) ? $data['deadline'] : null;
        $allowLate = isset($data['allow_late']) ? (int)$data['allow_late'] : 0;

        $query = "INSERT INTO tugas_pertemuan (id_pertemuan, judul_tugas, deskripsi, file_tugas, deadline, allow_late)
                  VALUES (:id_pertemuan, :judul_tugas, :deskripsi, :file_tugas, :deadline, :allow_late)";
        $this->db->query($query);
        $this->db->bind(':id_pertemuan', $data['id_pertemuan']);
        $this->db->bind(':judul_tugas', $deskripsiValue);
        $this->db->bind(':deskripsi', $deskripsiValue);
        $this->db->bind(':file_tugas', $fileName);
        $this->db->bind(':deadline', $deadline);
        $this->db->bind(':allow_late', $allowLate);
        $this->db->execute();
        
        return $this->db->rowCount();
    }

    /**
     * Hapus pertemuan beserta data terkait (sesi_absen, absen_pertemuan,
     * materi_pertemuan, pretest/posttest, tugas, pengumpulan_tugas)
     */
    public function hapusPertemuan($id_pertemuan)
    {
        try {
            // Mulai transaksi (Database wrapper tidak expose PDO transaction directly)
            $this->db->query('START TRANSACTION');
            $this->db->execute();

            // Hapus pengumpulan_tugas yang terkait (jawaban siswa)
            $this->db->query('DELETE gp FROM pengumpulan_tugas gp
                              JOIN tugas_pertemuan tp ON gp.id_tugas = tp.id_tugas
                              WHERE tp.id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus tugas_pertemuan
            $this->db->query('DELETE FROM tugas_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus materi_pertemuan
            $this->db->query('DELETE FROM materi_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus pretest & posttest
            $this->db->query('DELETE FROM pretest_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('DELETE FROM posttest_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus absen_pertemuan yang terkait melalui sesi_absen
            $this->db->query('DELETE a FROM absen_pertemuan a
                              JOIN sesi_absen s ON a.id_sesi = s.id_sesi
                              WHERE s.id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus progress_tracking yang merujuk ke pertemuan ini
            $this->db->query('DELETE FROM progress_tracking WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus sesi_absen
            $this->db->query('DELETE FROM sesi_absen WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Akhirnya hapus pertemuan itu sendiri
            $this->db->query('DELETE FROM pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Commit transaksi
            $this->db->query('COMMIT');
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            // Rollback transaksi bila terjadi error
            $this->db->query('ROLLBACK');
            $this->db->execute();
            error_log('ERROR hapusPertemuan: ' . $e->getMessage());
            return false;
        }
    }

    // Hapus hanya absen (daftar hadir + sesi)
    public function hapusAbsenByPertemuan($id_pertemuan)
    {
        try {
            $this->db->query('START TRANSACTION');
            $this->db->execute();

            // Hapus absen_pertemuan yang terkait melalui sesi_absen
            $this->db->query('DELETE a FROM absen_pertemuan a
                              JOIN sesi_absen s ON a.id_sesi = s.id_sesi
                              WHERE s.id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus sesi_absen
            $this->db->query('DELETE FROM sesi_absen WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('COMMIT');
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            $this->db->query('ROLLBACK');
            $this->db->execute();
            error_log('ERROR hapusAbsenByPertemuan: ' . $e->getMessage());
            return false;
        }
    }

    // Hapus tugas dan pengumpulan tugas
    public function hapusTugasByPertemuan($id_pertemuan)
    {
        try {
            $this->db->query('START TRANSACTION');
            $this->db->execute();

            // Hapus pengumpulan_tugas yang terkait
            $this->db->query('DELETE gp FROM pengumpulan_tugas gp
                              JOIN tugas_pertemuan tp ON gp.id_tugas = tp.id_tugas
                              WHERE tp.id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus tugas_pertemuan
            $this->db->query('DELETE FROM tugas_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('COMMIT');
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            $this->db->query('ROLLBACK');
            $this->db->execute();
            error_log('ERROR hapusTugasByPertemuan: ' . $e->getMessage());
            return false;
        }
    }

    // Hapus materi dan juga pre/post test terkait
    public function hapusMateriByPertemuan($id_pertemuan)
    {
        try {
            $this->db->query('START TRANSACTION');
            $this->db->execute();

            // Hapus posttest & pretest
            $this->db->query('DELETE FROM posttest_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('DELETE FROM pretest_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            // Hapus materi
            $this->db->query('DELETE FROM materi_pertemuan WHERE id_pertemuan = :id_pertemuan');
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('COMMIT');
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            $this->db->query('ROLLBACK');
            $this->db->execute();
            error_log('ERROR hapusMateriByPertemuan: ' . $e->getMessage());
            return false;
        }
    }

    // Hapus refleksi — only attempt if table exists
    public function hapusRefleksiByPertemuan($id_pertemuan)
    {
        try {
            $this->db->query('START TRANSACTION');
            $this->db->execute();

            // Try to delete from `refleksi` if table exists
            $this->db->query("DELETE FROM refleksi WHERE id_pertemuan = :id_pertemuan");
            $this->db->bind(':id_pertemuan', $id_pertemuan);
            $this->db->execute();

            $this->db->query('COMMIT');
            $this->db->execute();
            return true;
        } catch (Exception $e) {
            $this->db->query('ROLLBACK');
            $this->db->execute();
            // If table doesn't exist, swallowing error may be acceptable; log and return false
            error_log('ERROR hapusRefleksiByPertemuan: ' . $e->getMessage());
            return false;
        }
    }
}