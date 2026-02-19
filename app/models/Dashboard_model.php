<?php

class Dashboard_model {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllSiswa()
    {
        $this->db->query("SELECT * FROM siswa");
        return $this->db->resultSet();
    }

    // BARU: Fungsi untuk mendapatkan siswa yang BELUM terdaftar di mapel tertentu
    // Ini lebih baik agar dropdown tidak menampilkan siswa yang sudah ada
    // Di Dashboard_model.php

    public function getSiswaNotInMapel($id_mapel)
    {        
        $this->db->query("SELECT * FROM siswa_mapel WHERE id_mapel=:id_mapel");
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }

    /**
     * Mencari siswa yang belum terdaftar di sebuah mapel berdasarkan nama
     * Diperbaiki untuk error ONLY_FULL_GROUP_BY
     */
    public function searchSiswaNotInMapel($id_mapel, $query)
    {
        $sql = "SELECT MIN(s.id_siswa) as id_siswa, s.nama_siswa, s.kelas, MIN(s.usia) as usia, MIN(s.password) as password, MIN(s.status) as status
                FROM siswa s
                LEFT JOIN siswa_mapel sm ON s.id_siswa = sm.id_siswa AND sm.id_mapel = :id_mapel
                WHERE sm.id_siswa IS NULL AND s.nama_siswa LIKE :search
                GROUP BY s.nama_siswa, s.kelas
                ORDER BY s.nama_siswa
                LIMIT 10";
        
        $this->db->query($sql);
        $this->db->bind(':id_mapel', $id_mapel);
        $this->db->bind(':search', '%' . $query . '%');
        
        return $this->db->resultSet();
    }

    public function getSiswaByKelas($kelas, $id_mapel)
    {
        $this->db->query('SELECT * FROM siswa WHERE kelas=:kelas AND id_mapel=:id_mapel');
        $this->db->bind(':kelas', $kelas);
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }

    // Tambahkan fungsi ini di file Dashboard_model.php
    public function getSiswaByKelasAndMapel($kelas, $id_mapel)
    {
        $this->db->query('SELECT s.* FROM siswa s
                          JOIN siswa_mapel sm ON s.id_siswa = sm.id_siswa
                          WHERE s.kelas=:kelas AND sm.id_mapel=:id_mapel');
        $this->db->bind(':kelas', $kelas);
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }

    // Tambahkan juga fungsi ini untuk filter berdasarkan status
    public function getSiswaByStatusAndMapel($status, $id_mapel)
    {
        $this->db->query('SELECT s.* FROM siswa s
                          JOIN siswa_mapel sm ON s.id_siswa = sm.id_siswa
                          WHERE sm.status=:status AND sm.id_mapel=:id_mapel');
        $this->db->bind(':status', $status);
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }

    public function getSiswaByNama($nama)
    {
        $this->db->query('SELECT * FROM siswa WHERE nama_siswa LIKE :nama');
        $this->db->bind(':nama', '%' . $nama . '%');
        return $this->db->resultSet();
    }

    public function getSiswaByStatus($status)
    {
        $this->db->query('SELECT * FROM siswa WHERE status=:status');
        $this->db->bind(':status', $status);
        return $this->db->resultSet();
    }

    public function getSiswaByKelasAndNama($kelas, $nama)
    {
        $this->db->query('SELECT * FROM siswa WHERE kelas=:kelas AND nama_siswa LIKE :nama');
        $this->db->bind(':kelas', $kelas);
        $this->db->bind(':nama', '%' . $nama . '%');
        return $this->db->resultSet();
    }

    public function tambahSiswaKeMapel($id_siswa, $id_mapel)
    {
        // Kita tidak perlu mengecek duplikat di sini lagi karena database
        // sudah melakukannya dengan UNIQUE KEY.
        // Kita cukup coba memasukkan dan tangkap error jika terjadi duplikat.
        try {
            $query = 'INSERT INTO siswa_mapel (id_siswa, id_mapel, status) 
                      VALUES (:id_siswa, :id_mapel, :status)';
            
            $this->db->query($query);
            $this->db->bind(':id_siswa', $id_siswa);
            $this->db->bind(':id_mapel', $id_mapel);
            $this->db->bind(':status', 'Hadir'); // Status default
            
            $this->db->execute();
            return $this->db->rowCount() > 0;
        
        } catch (PDOException $e) {
            // Tangkap error jika terjadi pelanggaran constraint (duplikasi)
            // Kode error untuk unique constraint violation adalah 23000
            if ($e->getCode() == 23000) {
                return false; // Siswa sudah ada
            }
            // Lempar error kembali jika ini error lain
            throw $e;
        }
    }

    public function getMapelByGuru()
    {
        $this->db->query('SELECT * FROM mapel WHERE id_guru=:id_guru');
        $this->db->bind(':id_guru', $_SESSION['id_guru'] ?? '');
        return $this->db->resultSet();
    }


    public function getSiswaByMapel($id_mapel)
    {
        $query = "SELECT s.* FROM siswa s
                  JOIN siswa_mapel sm ON s.id_siswa = sm.id_siswa
                  WHERE sm.id_mapel = :id_mapel";
        
        $this->db->query($query);
        $this->db->bind(':id_mapel', $id_mapel);
        return $this->db->resultSet();
    }

    public function searchMapelByGuru($searchTerm)
    {
        $searchTerm = "%{$searchTerm}%";
        $this->db->query("SELECT * FROM mapel 
                        WHERE id_guru = :id_guru 
                        AND nama_mapel LIKE :searchTerm");
        $this->db->bind(':id_guru', $_SESSION['id_guru'] ?? '');
        $this->db->bind(':searchTerm', $searchTerm);
        return $this->db->resultSet();
    }
}