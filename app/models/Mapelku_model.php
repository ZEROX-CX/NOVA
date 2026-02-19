<?php

class Mapelku_model {
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }
    public function deleteMateri($id_materi)
    {
        $this->db->query("DELETE FROM pembelajaran WHERE id_materi = :id_materi");
        $this->db->bind(':id_materi', $id_materi);
        $this->db->execute();
        return $this->db->rowCount();
    }
}