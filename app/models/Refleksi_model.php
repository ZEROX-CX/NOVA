<?php

class Refleksi_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function simpanJawaban($id_siswa, $id_pertemuan, $jawab, $id_refleksi)
    {
        // Query sederhana tanpa pengecekan terlebih dahulu
        $this->db->query("INSERT INTO jawaban_refleksi 
            (id_siswa, id_pertemuan, jawaban, id_refleksi)
            VALUES (:id_siswa, :id_pertemuan, :jawaban, :id_refleksi)");
        
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->bind(':jawaban', $jawab);
        $this->db->bind(':id_refleksi', $id_refleksi);

        // Debug - Tampilkan query jika gagal
        if (!$this->db->execute()) {
            echo "Error: Gagal menyimpan jawaban<br>";
            echo "ID Siswa: " . $id_siswa . "<br>";
            echo "ID Pertemuan: " . $id_pertemuan . "<br>";
            echo "ID Refleksi: " . $id_refleksi . "<br>";
            echo "Jawaban: " . $jawab . "<br>";
            return false;
        }
        
        return true;
    }
    
    public function getRefleksiByPertemuan($id_pertemuan)
    {
        $this->db->query("SELECT * FROM refleksi_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    public function getJawabanBySiswaPertemuan($id_siswa, $id_pertemuan)
    {
        $this->db->query("SELECT jr.*, rp.pertanyaan 
                        FROM jawaban_refleksi jr 
                        JOIN refleksi_pertemuan rp ON jr.id_refleksi = rp.id_refleksi 
                        WHERE jr.id_siswa = :id_siswa AND jr.id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    public function getAllJawabanByPertemuan($id_pertemuan)
    {
        $this->db->query("SELECT jr.*, s.nama_siswa, rp.pertanyaan 
                        FROM jawaban_refleksi jr 
                        JOIN siswa s ON jr.id_siswa = s.id_siswa
                        JOIN refleksi_pertemuan rp ON jr.id_refleksi = rp.id_refleksi 
                        WHERE jr.id_pertemuan = :id_pertemuan
                        ORDER BY s.nama_siswa, jr.id_refleksi");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }
}