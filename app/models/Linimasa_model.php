<?php

class Linimasa_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllTugas(){
        
        $this->db->query("SELECT * FROM tugas_pertemuan");
        return $this->db->resultSet();
        }
        

    public function getTugasBelumDikumpulkan($id_siswa)
    {
        // Query untuk ambil semua tugas KECUALI yang sudah dikumpulkan oleh siswa
        $this->db->query("SELECT tp.*, p.id_mapel FROM tugas_pertemuan tp
                         JOIN pertemuan p ON tp.id_pertemuan = p.id_pertemuan
                         JOIN siswa_mapel sm ON p.id_mapel = sm.id_mapel
                         WHERE sm.id_siswa = :id_siswa
                         AND tp.id_tugas NOT IN (
                            SELECT id_tugas FROM pengumpulan_tugas 
                            WHERE id_siswa = :id_siswa
                         )");
        $this->db->bind(":id_siswa", $id_siswa);
        return $this->db->resultSet();
    }


    public function getBelumAbsensi()
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
                LEFT JOIN 
                    absen_pertemuan ap ON p.id_pertemuan = ap.id_pertemuan AND ap.id_siswa = :id_siswa
                WHERE 
                    p.id_mapel IN (
                        SELECT id_mapel 
                        FROM siswa_mapel 
                        WHERE id_siswa = :id_siswa
                    )
                AND ap.id_pertemuan IS NULL 
                ORDER BY 
                    p.tanggal ASC';

        $this->db->query($query);
        $this->db->bind(':id_siswa', $id_siswa);
        return $this->db->resultSet();
    }

    public function searchTugasAndAbsen($searchTerm)
    {
        $searchTerm = "%{$searchTerm}%";
        $this->db->query("SELECT tp.*, m.nama_mapel 
                        FROM siswa_mapel sm 
                        JOIN mapel m ON sm.id_mapel = m.id_mapel 
                        WHERE sm.id_siswa = :id_siswa 
                        AND m.nama_mapel LIKE :searchTerm");
        $this->db->bind(':id_siswa', $_SESSION['id_siswa'] ?? '');
        $this->db->bind(':searchTerm', $searchTerm);
        return $this->db->resultSet();
    }
}