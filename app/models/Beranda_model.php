<?php 

class Beranda_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getMapelSiswa()
    {
        $id_siswa = $_SESSION['id_siswa'] ?? 0;
        
        $query = 'SELECT DISTINCT m.id_mapel, m.nama_mapel
                  FROM mapel m
                  JOIN siswa_mapel sm ON m.id_mapel = sm.id_mapel
                  WHERE sm.id_siswa = :id_siswa
                  ORDER BY m.id_mapel ASC';
        
        $this->db->query($query);
        $this->db->bind('id_siswa', $id_siswa);
        return $this->db->resultSet();
    }

    public function getAllAbsen()
    {
        // Mendapatkan ID siswa dari session
        $id_siswa = $_SESSION['id_siswa'] ?? 0;
        
        // Query untuk mendapatkan sesi absen berdasarkan mapel yang diikuti siswa
        $query = 'SELECT 
                      sa.id_sesi, 
                      sa.kode_sesi, 
                      DATE_FORMAT(p.tanggal, "%Y-%m-%d") as tanggal,
                      p.judul_pertemuan as judul_absen,
                      p.id_pertemuan,
                      m.nama_mapel,
                      m.id_mapel
                  FROM 
                      sesi_absen sa
                  JOIN 
                      pertemuan p ON sa.id_pertemuan = p.id_pertemuan
                  JOIN 
                      mapel m ON p.id_mapel = m.id_mapel
                  WHERE 
                      p.id_mapel IN (
                          SELECT id_mapel 
                          FROM siswa_mapel 
                          WHERE id_siswa = :id_siswa
                      )
                  ORDER BY 
                      tanggal ASC';

        $this->db->query($query);
        $this->db->bind('id_siswa', $id_siswa);
        return $this->db->resultSet();
    }
}