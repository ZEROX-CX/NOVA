<?php

class Pretest_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getSoalByPertemuan($id_pertemuan)
    {
        $this->db->query("SELECT * FROM pretest_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->resultSet();
    }

    public function simpanNilai($id_siswa, $id_pertemuan, $nilai, $tab_switch_count = 0, $test_duration = 0)
    {
        $this->db->query("INSERT INTO nilai_pretest (id_siswa, id_pertemuan, nilai)
                        VALUES (:siswa, :pertemuan, :nilai)
                        ON DUPLICATE KEY UPDATE
                        nilai = VALUES(nilai)");

        $this->db->bind(':siswa', $id_siswa);
        $this->db->bind(':pertemuan', $id_pertemuan);
        $this->db->bind(':nilai', $nilai);

        // Kembalikan hasil eksekusi
        return $this->db->execute();
    }

    public function getNilai($id_siswa, $id_pertemuan)
    {
        $this->db->query("SELECT * FROM nilai_pretest WHERE id_siswa = :siswa AND id_pertemuan = :pertemuan");
        $this->db->bind(':siswa', $id_siswa);
        $this->db->bind(':pertemuan', $id_pertemuan);
        return $this->db->single();
    }

    public function getNilaiByPretest($id_pertemuan)
    {
        $this->db->query(
            "SELECT np.id_nilai, np.id_siswa, s.nama_siswa, np.nilai, np.tanggal
             FROM nilai_pretest np
             LEFT JOIN siswa s ON np.id_siswa = s.id_siswa
             WHERE np.id_pertemuan = :id_pertemuan
             ORDER BY np.tanggal DESC"
        );
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        $this->db->execute();
        return $this->db->resultSet();
    }

    public function getSoalById($id_pretest)
    {
        $this->db->query("SELECT * FROM pretest_pertemuan WHERE id_pretest = :id_pretest");
        $this->db->bind(':id_pretest', $id_pretest);
        return $this->db->single();
    }

    public function tambahSoal($data)
    {
        $query = "INSERT INTO pretest_pertemuan (id_pertemuan, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar) 
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

    public function updateSoal($id_pretest, $data)
    {
        $query = "UPDATE pretest_pertemuan 
                  SET pertanyaan = :pertanyaan, 
                      opsi_a = :opsi_a, 
                      opsi_b = :opsi_b, 
                      opsi_c = :opsi_c, 
                      opsi_d = :opsi_d, 
                      jawaban_benar = :jawaban_benar 
                  WHERE id_pretest = :id_pretest";
        
        $this->db->query($query);
        $this->db->bind(':pertanyaan', $data['pertanyaan']);
        $this->db->bind(':opsi_a', $data['opsi_a']);
        $this->db->bind(':opsi_b', $data['opsi_b']);
        $this->db->bind(':opsi_c', $data['opsi_c']);
        $this->db->bind(':opsi_d', $data['opsi_d']);
        $this->db->bind(':jawaban_benar', $data['jawaban_benar']);
        $this->db->bind(':id_pretest', $id_pretest);
        
        $this->db->execute();
    }

    public function deleteSoal($id_pretest)
    {
        $query = "DELETE FROM pretest_pertemuan WHERE id_pretest = :id_pretest";
        $this->db->query($query);
        $this->db->bind(':id_pretest', $id_pretest);
        $this->db->execute();
    }
}