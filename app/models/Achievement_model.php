<?php

class Achievement_model {
    private $db;


    public function __construct() {
        $this->db = new Database;
    }

    public function unlockAchivementSiswa_teladan($id_siswa, $achievement_type)
    {
        // Cari id_achievement berdasarkan nama_achievement
        $this->db->query("SELECT id_achievement FROM achievements WHERE nama_achievement = :achievement_type");
        $this->db->bind(':achievement_type', $achievement_type);
        $result = $this->db->single();
        if (!$result) {
            return false; // Achievement tidak ditemukan
        }
        $id_achievement = $result['id_achievement'];

        $sudahAda = $this->db->query("SELECT * FROM siswa_achievement WHERE id_achievement= :id_achievement AND id_siswa = :id_siswa ");
        $this->db->bind(':id_achievement', $id_achievement);
        $this->db->bind(':id_siswa', $id_siswa);
        return $this->db->resultSet();

        if($sudahAda){
            return false;
        }
        // Insert ke siswa_achievements
        $_SESSION['toast'] = [
            'type' => 'success',
            'message' => 'Meraih Pencapaian Siswa Teladan'
        ];
        $this->db->query("INSERT INTO siswa_achievements (id_siswa, id_achievement) VALUES (:id_siswa, :id_achievement)");
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':id_achievement', $id_achievement);
        return $this->db->execute();
    }


    public function checkAchievement($id_siswa, $achievement_type) {
        $this->db->query("SELECT sa.* FROM siswa_achievements sa JOIN achievements a ON sa.id_achievement = a.id_achievement WHERE sa.id_siswa = :id_siswa AND a.nama_achievement = :achievement_type");
        $this->db->bind(':id_siswa', $id_siswa);
        $this->db->bind(':achievement_type', $achievement_type);
        $this->db->single();
        return $this->db->rowCount() > 0;
    }

    public function sudahAdaSiswa_teladan($id_siswa, $achievement_type)
    {
        $this->db->query("SELECT id_achievement FROM achievements WHERE nama_achievement = :achievement_type");
        $this->db->bind(':achievement_type', $achievement_type);
        $result = $this->db->single();
         if (!$result) {
            return false; // Achievement tidak ditemukan
        }
        $id_achievement = $result['id_achievement'];

        $this->db->query("SELECT * FROM siswa_achievement WHERE id_achievement= :id_achievement AND id_siswa = :id_siswa");
        $this->db->bind(":id_achievement", $id_achievement);
        $this->db->bind(":id_siswa", $id_siswa);
        return $this->db->single();
    }

}