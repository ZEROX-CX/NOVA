<?php

class Posttest_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getSoalByPertemuan($id_pertemuan)
    {
        $this->db->query("SELECT * FROM posttest_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    public function simpanNilai($id_siswa, $id_pertemuan, $nilai)
    {
        // Ganti INSERT INTO dengan REPLACE INTO
        $this->db->query("REPLACE INTO nilai_posttest (id_siswa, id_pertemuan, nilai) VALUES (:siswa, :pertemuan, :nilai)");
        $this->db->bind(':siswa', $id_siswa);
        $this->db->bind(':pertemuan', $id_pertemuan);
        $this->db->bind(':nilai', $nilai);
        return $this->db->execute();
    }

    public function getNilai($id_siswa, $id_pertemuan)
    {
        $this->db->query("SELECT * FROM nilai_posttest WHERE id_siswa = :siswa AND id_pertemuan = :pertemuan");
        $this->db->bind(':siswa', $id_siswa);
        $this->db->bind(':pertemuan', $id_pertemuan);
        return $this->db->single();
    }

    public function getNilaiByPosttest($id_pertemuan)
    {
        $this->db->query(
            "SELECT np.id_nilai, np.id_siswa, s.nama_siswa, np.nilai, np.tanggal
             FROM nilai_posttest np
             LEFT JOIN siswa s ON np.id_siswa = s.id_siswa
             WHERE np.id_pertemuan = :id_pertemuan
             ORDER BY np.tanggal DESC"
        );
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getSoalById($id_posttest)
    {
        $this->db->query("SELECT * FROM posttest_pertemuan WHERE id_posttest = :id_posttest");
        $this->db->bind(':id_posttest', $id_posttest);
        return $this->db->single();
    }

        public function tambahSoal($data)
    {
        $query = "INSERT INTO posttest_pertemuan (id_pertemuan, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
                  VALUES(:id_pertemuan, :pertanyaan, :opsi_a, :opsi_b, :opsi_c, :opsi_d, :jawaban_benar)";
        
        $this->db->query($query);
        $this->db->bind(':id_pertemuan', $data['id_pertemuan']);
        $this->db->bind(':pertanyaan', $data['pertanyaan']);
        $this->db->bind(':opsi_a', $data['opsi_a']);
        $this->db->bind(':opsi_b', $data['opsi_b']);
        $this->db->bind(':opsi_c', $data['opsi_c']);
        $this->db->bind(':opsi_d', $data['opsi_d']);
        $this->db->bind(':jawaban_benar', $data['jawaban_benar']);
        
        $this->db->execute();
    }

    public function updateSoal($id_posttest, $data)
    {
        $query = "UPDATE posttest_pertemuan 
                  SET pertanyaan = :pertanyaan, 
                      opsi_a = :opsi_a, 
                      opsi_b = :opsi_b, 
                      opsi_c = :opsi_c, 
                      opsi_d = :opsi_d, 
                      jawaban_benar = :jawaban_benar 
                  WHERE id_posttest = :id_posttest";
        
        $this->db->query($query);
        $this->db->bind(':pertanyaan', $data['pertanyaan']);
        $this->db->bind(':opsi_a', $data['opsi_a']);
        $this->db->bind(':opsi_b', $data['opsi_b']);
        $this->db->bind(':opsi_c', $data['opsi_c']);
        $this->db->bind(':opsi_d', $data['opsi_d']);
        $this->db->bind(':jawaban_benar', $data['jawaban_benar']);
        $this->db->bind(':id_posttest', $id_posttest);
        
        $this->db->execute();
    }

    public function deleteSoal($id_posttest)
    {
        $query = "DELETE FROM posttest_pertemuan WHERE id_posttest = :id_posttest";
        $this->db->query($query);
        $this->db->bind(':id_posttest', $id_posttest);
        $this->db->execute();
    }
}