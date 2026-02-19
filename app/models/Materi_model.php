<?php

class Materi_model {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Ambil satu materi berdasarkan id pertemuan
    public function getMateriByPertemuan($id_pertemuan) {
        $this->db->query("SELECT * FROM materi_pertemuan WHERE id_pertemuan = :id_pertemuan LIMIT 1");
        $this->db->bind(":id_pertemuan", $id_pertemuan);
        return $this->db->single(); // Akan mengembalikan false jika tidak ada
    }

    // Ambil satu materi berdasarkan id materi
    public function getMateriById($id_materi) {
        $this->db->query("SELECT * FROM materi_pertemuan WHERE id = :id");
        $this->db->bind(":id", $id_materi);
        return $this->db->single();
    }

    // Cek apakah siswa sudah menyelesaikan membaca materi (tanda di tabel progress_tracking)
    public function hasCompletedTugas($id_siswa, $id_materi) {
        $this->db->query("SELECT id_progress FROM progress_tracking 
                          WHERE id_siswa = :id_siswa 
                          AND id_tugas = :id_materi 
                          AND tipe_aktivitas = 'tugas' 
                          AND status = 'selesai'
                          LIMIT 1");
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_materi', $id_materi);
        $result = $this->db->single();
        return !empty($result); // Mengembalikan true jika ada record
    }

    // Tandai selesai membaca dengan menambah/update record di progress_tracking
    public function markTugasCompleted($id_siswa, $id_materi) {
        // Cek apakah record sudah ada
        $this->db->query("SELECT id_progress FROM progress_tracking 
                          WHERE id_siswa = :id_siswa 
                          AND id_tugas = :id_materi 
                          AND tipe_aktivitas = 'tugas'
                          LIMIT 1");
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_materi', $id_materi);
        $existing = $this->db->single();

        if ($existing) {
            // Update record yang sudah ada
            $this->db->query("UPDATE progress_tracking 
                              SET status = 'selesai', 
                                  progress_percentage = 100,
                                  waktu_selesai = NOW()
                              WHERE id_progress = :id_progress");
            $this->db->bind(':id_progress', $existing['id_progress']);
            return $this->db->execute();
        } else {
            // Insert record baru
            $this->db->query("INSERT INTO progress_tracking 
                              (id_siswa, id_tugas, tipe_aktivitas, status, progress_percentage, waktu_mulai, waktu_selesai, created_at)
                              VALUES (:id_siswa, :id_materi, 'tugas', 'selesai', 100, NOW(), NOW(), NOW())");
            $this->db->bind(':id_siswa', $id_siswa);
            $this->db->bind(':id_materi', $id_materi);
            return $this->db->execute();
        }
    }
    
    // Cek apakah file PDF ada di server
    public function checkPdfExists($file_materi) {
        if (empty($file_materi)) {
            return false;
        }
        
        $path = "uploads/materi/" . $file_materi;
        return file_exists($path);
    }

    public function updateMateri($id_materi, $data)
    {
        // Query untuk mengupdate data materi
        // Saat ini kita hanya update isi_materi dan link_youtube
        // Logik untuk upload file bisa ditambahkan di sini
        $query = "UPDATE materi_pertemuan 
                  SET isi_materi = :isi_materi, 
                      link_youtube = :link_youtube
                  WHERE id = :id_materi";
        
        $this->db->query($query);
        $this->db->bind(':isi_materi', $data['isi_materi']);
        $this->db->bind(':link_youtube', $data['link_youtube']);
        $this->db->bind(':id_materi', $id_materi);
        
        return $this->db->execute();
    }
}