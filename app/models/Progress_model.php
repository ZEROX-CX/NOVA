<?php

class Progress_model {

    private $db;

    public function __construct()
    {
        // Sesuaikan nama class Database dengan project kamu
        $this->db = new Database;
    }

    public function saveProgress($data)
    {
        try {
            $this->db->query("
                INSERT INTO progress_tracking (
                    id_siswa, id_pertemuan, id_materi, id_tugas, id_game,
                    tipe_aktivitas, status, progress_percentage, waktu_mulai,
                    waktu_selesai, durasi_pengerjaan, skor
                ) VALUES (
                    :id_siswa, :id_pertemuan, :id_materi, :id_tugas, :id_game,
                    :tipe_aktivitas, :status, :progress_percentage, :waktu_mulai,
                    :waktu_selesai, :durasi_pengerjaan, :skor
                )
            ");

            $this->db->bind(':id_siswa', $data['id_siswa']);
            $this->db->bind(':id_pertemuan', $data['id_pertemuan'] ?? null);
            $this->db->bind(':id_materi', $data['id_materi'] ?? null);
            $this->db->bind(':id_tugas', $data['id_tugas'] ?? null);
            $this->db->bind(':id_game', $data['id_game'] ?? null);
            $this->db->bind(':tipe_aktivitas', $data['tipe_aktivitas']);
            $this->db->bind(':status', $data['status'] ?? 'selesai');
            $this->db->bind(':progress_percentage', $data['progress_percentage'] ?? 100);
            $this->db->bind(':waktu_mulai', $data['waktu_mulai'] ?? null);
            $this->db->bind(':waktu_selesai', $data['waktu_selesai'] ?? date('Y-m-d H:i:s'));
            $this->db->bind(':durasi_pengerjaan', $data['durasi_pengerjaan'] ?? null);
            $this->db->bind(':skor', $data['skor'] ?? null);

            return $this->db->execute();
        } catch (Exception $e) {
            // Log error untuk debugging
            error_log("Error saving progress: " . $e->getMessage());
            return false;
        }
    }


    public function getProgressBySiswa($id_siswa)
    {
        try {
            $this->db->query("SELECT * FROM progress_tracking WHERE id_siswa = :id_siswa ORDER BY created_at DESC");
            $this->db->bind(':id_siswa', $id_siswa);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting progress: " . $e->getMessage());
            return [];
        }
    }

    public function getSummary($id_siswa)
    {
        try {
            $this->db->query("
                SELECT tipe_aktivitas, COUNT(*) AS total, 
                    SUM(CASE WHEN status='selesai' THEN 1 ELSE 0 END) AS selesai
                FROM progress_tracking
                WHERE id_siswa = :id_siswa
                GROUP BY tipe_aktivitas 
            ");
            $this->db->bind(':id_siswa', $id_siswa);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting summary: " . $e->getMessage());
            return [];
        }
    }

    public function countAbsenBySiswa($id_siswa)
    {
        $this->db->query("SELECT COUNT(*) as total FROM progress_tracking WHERE id_siswa = :id_siswa AND tipe_aktivitas = 'absen'");
        $this->db->bind(':id_siswa', $id_siswa);
        // Karena hasilnya hanya satu angka, gunakan single() bukan resultSet()
        $result = $this->db->single(); 
        return $result['total'] ?? 0; // Kembalikan nilai total, atau 0 jika tidak ada
    }
}