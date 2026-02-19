<?php 

class Pengumpulan_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getPengumpulanBySiswaDanTugas($id_siswa, $id_tugas) {
        $this->db->query('SELECT * FROM pengumpulan_tugas WHERE id_siswa = :id_siswa AND id_tugas = :id_tugas');
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_tugas', $id_tugas);
        return $this->db->single(); // Kembalikan satu baris atau null
    }

    // Method untuk mengedit pengumpulan (update file dan status)
    public function editPengumpulan($id_siswa, $id_tugas, $data) {
        try {
            $query = 'UPDATE pengumpulan_tugas 
                      SET file_jawaban = :file_jawaban, tanggal_kumpul = NOW(), is_late = :is_late 
                      WHERE id_siswa = :id_siswa AND id_tugas = :id_tugas';
            
            $this->db->query($query);
            $this->db->bind(':file_jawaban', $data['file_jawaban']);
            $this->db->bind(':is_late', $data['is_late']);
            $this->db->bind(':id_siswa', $id_siswa);
            $this->db->bind(':id_tugas', $id_tugas);
            
            $ok = $this->db->execute();
            if (!$ok) {
                error_log('ERROR editPengumpulan execute failed: ' . $this->db->getError());
                return false;
            }

            $rowCount = $this->db->rowCount();
            error_log('editPengumpulan success: updated ' . $rowCount . ' rows');
            return $rowCount;
        } catch (Exception $e) {
            error_log('ERROR editPengumpulan: ' . $e->getMessage());
            return false;
        }
    }

    public function kumpulTugas($id_tugas, $data, $id_siswa_passed = null)
    {
        try {
            $id_siswa = $id_siswa_passed ?? ($_SESSION['id_siswa'] ?? null);
            if (!$id_siswa) {
                error_log('ERROR kumpulTugas: id_siswa not in session');
                return false;
            }

            $file_jawaban = $data['file_jawaban'] ?? null;
            $is_late = $data['is_late'] ?? 0;

            $sql = 'INSERT INTO pengumpulan_tugas (id_tugas, id_siswa, file_jawaban, tanggal_kumpul, is_late) VALUES (:id_tugas, :id_siswa, :file_jawaban, NOW(), :is_late)';
            
            $this->db->query($sql);
            $this->db->bind(':id_tugas', (int)$id_tugas, PDO::PARAM_INT);
            $this->db->bind(':id_siswa', (int)$id_siswa, PDO::PARAM_INT);
            $this->db->bind(':file_jawaban', $file_jawaban, PDO::PARAM_STR);
            $this->db->bind(':is_late', (int)$is_late, PDO::PARAM_INT);
            
            $ok = $this->db->execute();
            
            if (!$ok) {
                $error = $this->db->getError();
                error_log('ERROR kumpulTugas execute failed: ' . $error);
                return false;
            }

            $rowCount = $this->db->rowCount();
            error_log('kumpulTugas success: inserted ' . $rowCount . ' rows');
            return $rowCount;
        } catch (Exception $e) {
            error_log('ERROR kumpulTugas EXCEPTION: ' . $e->getMessage());
            return false;
        }
    }

    public function getPengumpulanByTugas($id_tugas) 
    {
        $this->db->query('SELECT * FROM pengumpulan_tugas WHERE id_tugas = :id_tugas');
        $this->db->bind(':id_tugas', $id_tugas);
        return $this->db->resultSet(); // Kembalikan semua baris
    }
}