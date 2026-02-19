<?php 

class Tugas_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;           
    }

    public function getTugasByPertemuan($id_pertemuan)
    {   
        $this->db->query('SELECT * FROM tugas_pertemuan WHERE id_pertemuan=:id_pertemuan');
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet(); // Mengembalikan semua baris data
    }

    public function getTugasById($id_tugas) {
        // PASTIKAN 'allow_late' ADA di dalam SELECT
        $this->db->query('SELECT *, DATE_FORMAT(deadline, "%Y-%m-%d %H:%i") as deadline_formatted FROM tugas_pertemuan WHERE id_tugas = :id_tugas');
        $this->db->bind(':id_tugas', $id_tugas);
        return $this->db->single();
    }

    public function getTugas($id_tugas)
    {
        $this->db->query('SELECT * FROM tugas_pertemuan WHERE id_tugas=:id_tugas');
        $this->db->bind(':id_tugas', $id_tugas);
        return $this->db->single();
    }

    public function updateTugas($id_pertemuan, $data, $file_tugas = null)
    {
        $query = "UPDATE tugas_pertemuan SET judul_tugas = :judul_tugas, deskripsi = :deskripsi, deadline = :deadline, allow_late = :allow_late";
        
        if ($file_tugas !== null) {
            $query .= ", file_tugas = :file_tugas";
        }
        
        // 🔹 PERUBAHAN UTAMA: WHERE clause menggunakan id_pertemuan
        $query .= " WHERE id_pertemuan = :id_pertemuan";
        
        $this->db->query($query);
        $this->db->bind(':judul_tugas', $data['judul_tugas']);
        $this->db->bind(':deskripsi', $data['deskripsi']);
        $this->db->bind(':deadline', $data['deadline']);
        $this->db->bind(':allow_late', $data['allow_late']);
        
        if ($file_tugas !== null) {
            $this->db->bind(':file_tugas', $file_tugas);
        }
        
        // 🔹 PERUBAHAN UTAMA: Bind parameter menggunakan id_pertemuan
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        
        return $this->db->execute();
    }
}