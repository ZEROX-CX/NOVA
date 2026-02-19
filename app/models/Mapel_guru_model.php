<?php
class Mapel_guru_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllMateri()
    {
        $this->db->query("SELECT id_materi, materi, mapel, judul FROM pembelajaran");
        return $this->db->resultSet();
    }

    public function getAllMapelList()
    {
        $this->db->query("SELECT DISTINCT mapel FROM pembelajaran ORDER BY mapel ASC");
        $results = $this->db->resultSet();

        // Ambil hanya kolom 'mapel' agar lebih sederhana
        $mapel_list = [];
        foreach ($results as $row) {
            $mapel_list[] = $row['mapel'];
        }

        return $mapel_list;
    }


    public function tambahDataMateri($data)
    {
        $judul = $data['judul_materi'];
        $query = ('INSERT INTO pembelajaran (judul, mapel) VALUES (:judul, :mapel)');
        $this->db->query($query);
        $this->db->bind(":judul", $judul); 
        $this->db->bind(":mapel", $data['mapel']);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function editDataMateri($data, $id)
    {
        $judul = $data['judul_materi'];
        $judul = preg_replace('/<p[^>]*>/', '', $judul);
        $judul = str_replace('</p>', '', $judul);
        $judul = strip_tags($judul, '<b><i><u>');
        $judul = trim(preg_replace('/\s+/', ' ', $judul));

        $query = ('UPDATE pembelajaran SET judul=:judul, mapel=:mapel WHERE id_materi=:id_materi');
        $this->db->query($query);
        $this->db->bind(":judul", $judul);
        $this->db->bind(":mapel", $data['mapel']);
        $this->db->bind(":id_materi", $id);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function deleteMateri($id_materi)
    {
        $this->db->query("DELETE FROM pembelajaran WHERE id_materi = :id_materi");
        $this->db->bind(':id_materi', $id_materi);
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function getMateriById($id_materi)
    {
        $this->db->query("SELECT * FROM pembelajaran WHERE id_materi = :id_materi");
        $this->db->bind(':id_materi', $id_materi);
        return $this->db->single();
    }

    public function getMateriByPertemuanId($id_pertemuan)
    {
        $this->db->query("SELECT * FROM materi_pertemuan WHERE id_pertemuan = :id_pertemuan");
        $this->db->bind(':id_pertemuan', $id_pertemuan);
        return $this->db->single();
    }

    public function getMapelById($id_materi)
    {
        $this->db->query("SELECT * FROM pembelajaran WHERE id_materi = :id_materi");
        $this->db->bind(':id_materi', $id_materi);
        return $this->db->single();
    }
    public function getAllMapel()
    {
        $this->db->query("SELECT sm.*, m.nama_mapel FROM siswa_mapel sm JOIN mapel m ON sm.id_mapel = m.id_mapel WHERE sm.id_siswa = :id_siswa;");
        $this->db->bind(':id_siswa', $_SESSION['id_siswa'] ?? '');
        return $this->db->resultSet();
    }

    public function searchMapel($searchTerm)
    {
        $searchTerm = "%{$searchTerm}%";
        $this->db->query("SELECT sm.*, m.nama_mapel 
                        FROM siswa_mapel sm 
                        JOIN mapel m ON sm.id_mapel = m.id_mapel 
                        WHERE sm.id_siswa = :id_siswa 
                        AND m.nama_mapel LIKE :searchTerm");
        $this->db->bind(':id_siswa', $_SESSION['id_siswa'] ?? '');
        $this->db->bind(':searchTerm', $searchTerm);
        return $this->db->resultSet();
    }
}