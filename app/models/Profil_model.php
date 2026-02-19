<?php

class Profil_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getkelasBySiswa() {
        $this->db->query('SELECT kelas FROM siswa WHERE id_siswa=:id_siswa');
        $this->db->bind('id_siswa', $_SESSION['id_siswa'] ?? '');
        return $this->db->single();
    }

    public function gantiProfil($data)
    {
        // Periksa apakah ada file yang diupload
        if (!empty($data['file']['name'])) {
            $targetDir = __DIR__ . "/../../public/uploads/profil/";
            $fileName = time() . "_" . basename($data['file']['name']);
            $targetFilePath = $targetDir . $fileName;

           if (move_uploaded_file($data['file']['tmp_name'], $targetFilePath)) {
                echo "File berhasil diunggah ke folder.<br>";

                $query = "UPDATE siswa SET foto_profil = :foto_profil WHERE id_siswa = :id_siswa";
                $this->db->query($query);
                $this->db->bind('foto_profil', $fileName);
                $this->db->bind('id_siswa', $data['id_siswa']);

                if ($this->db->execute()) {
                    echo "Database berhasil diupdate.<br>";
                    $_SESSION['foto'] = $fileName;
                    return true;
                } else {
                   echo "ERROR: Gagal mengupdate database.<br>";
                    unlink($targetFilePath);
                    return false;
                }
            }
        }
    }


    public function getKelaminBySiswa()
    {
        $this->db->query('SELECT jeniskelamin FROM siswa WHERE id_siswa=:id_siswa');
        $this->db->bind(':id_siswa', $_SESSION['id_siswa'] ?? '');
        return $this->db->single();
    }


    public function getTanggalDaftar()
    {
        $this->db->query('SELECT tanggal_daftar FROM siswa WHERE id_siswa=:id_siswa');
        $this->db->bind(':id_siswa', $_SESSION['id_siswa'] ?? '');
        return $this->db->single();
    }

    public function getTanggalDaftarGuru()
    {
        $this->db->query('SELECT tanggal_daftar FROM guru WHERE id_guru=:id_guru');
        $this->db->bind(':id_guru', $_SESSION['id_guru'] ?? '');
        return $this->db->single();
    }

    public function gantiProfilGuru($data)
    {
        if (!empty($data['file']['name'])) {
            $targetDir = __DIR__ . "/../../public/uploads/profil/";
            $fileName = time() . "_" . basename($data['file']['name']);
            $targetFilePath = $targetDir . $fileName;

           if (move_uploaded_file($data['file']['tmp_name'], $targetFilePath)) {
                echo "File berhasil diunggah ke folder.<br>";

                $query = "UPDATE guru SET foto_profil = :foto_profil WHERE id_guru = :id_guru";
                $this->db->query($query);
                $this->db->bind('foto_profil', $fileName);
                $this->db->bind('id_guru', $data['id_guru']);

                if ($this->db->execute()) {
                    echo "Database berhasil diupdate.<br>";
                    $_SESSION['foto'] = $fileName;
                    return true;
                } else {
                   echo "ERROR: Gagal mengupdate database.<br>";
                    unlink($targetFilePath);
                    return false;
                }
            }
        }
    }
}