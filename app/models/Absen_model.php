<?php

class Absen_model extends Controllers{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    
    public function insertIntoAbsen($id_pertemuan, $id_siswa, $data)
    {
        // Sanitasi input terlebih dahulu
        $status = isset($data['status']) ? trim($data['status']) : null;
        $keterangan = isset($data['keterangan']) ? trim($data['keterangan']) : '';

        if (empty($status)) {
            return 0; // tidak ada status -> tidak melakukan insert
        }     // Cek apakah sesi absen sudah ada
        $sesi = $this->model('Pertemuan_model')->getSesiByPertemuan($id_pertemuan);

        // Jika tidak ada sesi aktif, buat sesi baru
        if (!$sesi) {
            $id_sesi = $this->model('Pertemuan_model')->tambahSesiAbsen(['id_pertemuan' => $id_pertemuan]);
            
            // Cek apakah pembuatan sesi berhasil
            if (!$id_sesi || $id_sesi === 0) {
                error_log("Gagal membuat sesi absen untuk pertemuan $id_pertemuan");
                return 0;
            }
        } else {
            $id_sesi = $sesi["id_sesi"];
        }

        // Insert data absen dengan semua data terisi lengkap
        $this->db->query("INSERT INTO absen_pertemuan (id_pertemuan, id_sesi, id_siswa, status, keterangan, waktu_absen)
                      VALUES (:id_pertemuan, :id_sesi, :id_siswa, :status, :keterangan, NOW())"); 
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->bind(':id_sesi', $id_sesi);
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':status', $status);
        $this->db->bind(':keterangan', $keterangan);

        $ok = $this->db->execute();
        if (!$ok) {
            error_log("Gagal insert absen untuk siswa $id_siswa di pertemuan $id_pertemuan");
            return 0;
        }

        return $this->db->rowCount();
    }

    public function cekKehadiran($id_pertemuan, $id_siswa)
    {
        $this->db->query("SELECT * FROM absen_pertemuan WHERE id_pertemuan = :id_pertemuan AND id_siswa = :id_siswa");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->bind(':id_siswa', $id_siswa);
        return $this->db->single(); // Mengembalikan data absen jika ada, null jika tidak ada
    }

    public function getAbsenByPertemuan($id_pertemuan)
    {
        $this->db->query("
            SELECT 
                a.id_absen,
                a.id_siswa,
                s.nama_siswa,
                a.status,
                a.keterangan
            FROM absen_pertemuan a
            JOIN siswa s ON a.id_siswa = s.id_siswa
            WHERE a.id_pertemuan = :id_pertemuan
            ORDER BY a.id_absen ASC
        ");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    public function editAbsen($id_pertemuan, $tanggalAbsen)
    {
        $formattedDate = date('Y-m-d', strtotime($tanggalAbsen));
        
        // Debug: Tambahkan log untuk melihat query yang dijalankan
        error_log("Update sesi_absen dengan id_pertemuan: $id_pertemuan, tanggal: $formattedDate");
        
        $this->db->query("UPDATE sesi_absen SET tanggal_buat = :waktu_absen WHERE id_pertemuan = :id_pertemuan");
        
        $this->db->bind(':waktu_absen', $formattedDate);
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        
        $this->db->execute();
        $rowCount = $this->db->rowCount();
        
        // Debug: Tambahkan log untuk melihat jumlah baris yang terpengaruh
        error_log("Jumlah baris yang terpengaruh: $rowCount");
        
        return $rowCount > 0;
    }
}