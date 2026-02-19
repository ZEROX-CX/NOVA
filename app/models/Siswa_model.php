<?php 
// app/models/Siswa_model.php

class Siswa_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Mendapatkan semua siswa yang terdaftar di sebuah mapel tertentu
     */
    public function getSiswaByMapel($id_mapel)
    {
        $this->db->query('
            SELECT s.id_siswa, s.nama_siswa, s.kelas 
            FROM siswa s
            JOIN siswa_mapel sm ON s.id_siswa = sm.id_siswa
            WHERE sm.id_mapel = :id_mapel
            ORDER BY s.nama_siswa ASC
        ');
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }
}