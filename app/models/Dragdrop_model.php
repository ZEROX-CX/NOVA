<?php

class Dragdrop_model {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // ==========================
    // GAME
    // ==========================
    public function getAllGames() {
        $this->db->query("SELECT * FROM drag_drop_game ORDER BY id_game DESC");
        return $this->db->resultSet();
    }

    public function getGameData($id_game) {

        // AREAS
        $this->db->query("SELECT * FROM drag_drop_area WHERE id_game = :id");
        $this->db->bind(":id", $id_game);
        $areas = $this->db->resultSet();

        // ITEMS
        $this->db->query("SELECT * FROM drag_drop_item WHERE id_game = :id");
        $this->db->bind(":id", $id_game);
        $items = $this->db->resultSet();

        return [
            "id_game" => $id_game,
            "areas"   => $areas,
            "items"   => $items
        ];
    }

    public function createGame($judul, $id_guru) {
        $this->db->query("
            INSERT INTO drag_drop_game (judul, id_guru)
            VALUES (:judul, :id_guru)
        ");
        $this->db->bind(":judul", $judul);
        $this->db->bind(":id_guru", $id_guru);

        return $this->db->execute();
    }

    public function updateGame($id_game, $judul) {
        $this->db->query("
            UPDATE drag_drop_game 
            SET judul = :judul 
            WHERE id_game = :id
        ");
        $this->db->bind(":judul", $judul);
        $this->db->bind(":id", $id_game);

        return $this->db->execute();
    }

    public function deleteGame($id) {
        // Hapus anak-anaknya dulu
        $this->db->query("DELETE FROM drag_drop_item WHERE id_game = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();

        $this->db->query("DELETE FROM drag_drop_area WHERE id_game = :id");
        $this->db->bind(":id", $id);
        $this->db->execute();

        // Hapus game
        $this->db->query("DELETE FROM drag_drop_game WHERE id_game = :id");
        $this->db->bind(":id", $id);

        return $this->db->execute();
    }

    // ==========================
    // AREA
    // ==========================
    public function getAreas($id_game) {
        $this->db->query("SELECT * FROM drag_drop_area WHERE id_game = :id ORDER BY id_area ASC");
        $this->db->bind(":id", $id_game);
        return $this->db->resultSet();
    }

    public function createArea($id_game, $nama) {
        $this->db->query("
            INSERT INTO drag_drop_area (id_game, nama_area)
            VALUES (:id_game, :nama)
        ");
        $this->db->bind(":id_game", $id_game);
        $this->db->bind(":nama", $nama);
        return $this->db->execute();
    }

    public function updateArea($id, $nama) {
        $this->db->query("
            UPDATE drag_drop_area 
            SET nama_area = :nama 
            WHERE id_area = :id
        ");
        $this->db->bind(":nama", $nama);
        $this->db->bind(":id", $id);
        return $this->db->execute();
    }

    public function deleteArea($id_area) {
        // Set item correct_area_id = NULL dulu agar aman
        $this->db->query("
            UPDATE drag_drop_item 
            SET correct_area_id = NULL
            WHERE correct_area_id = :id
        ");
        $this->db->bind(":id", $id_area);
        $this->db->execute();

        // Delete area
        $this->db->query("DELETE FROM drag_drop_area WHERE id_area = :id");
        $this->db->bind(":id", $id_area);
        return $this->db->execute();
    }

    // ==========================
    // ITEM
    // ==========================
    public function getItems($id_game) {
        $this->db->query("SELECT * FROM drag_drop_item WHERE id_game = :id ORDER BY id_item ASC");
        $this->db->bind(":id", $id_game);
        return $this->db->resultSet();
    }

    public function createItem($id_game, $nama_item, $correct_area_id) {
        $this->db->query("
            INSERT INTO drag_drop_item (id_game, nama_item, correct_area_id)
            VALUES (:id_game, :item, :area)
        ");
        $this->db->bind(":id_game", $id_game);
        $this->db->bind(":item", $nama_item);
        $this->db->bind(":area", $correct_area_id);

        return $this->db->execute();
    }

    public function updateItem($id_item, $nama_item, $correct_area_id) {
        $this->db->query("
            UPDATE drag_drop_item
            SET nama_item = :nama, correct_area_id = :area
            WHERE id_item = :id
        ");
        $this->db->bind(":nama", $nama_item);
        $this->db->bind(":area", $correct_area_id);
        $this->db->bind(":id", $id_item);

        return $this->db->execute();
    }

    public function deleteItem($id_item) {
        $this->db->query("DELETE FROM drag_drop_item WHERE id_item = :id");
        $this->db->bind(":id", $id_item);
        return $this->db->execute();
    }

    // ==========================
    // SAVE SCORE
    // ==========================
    public function saveScore($id_siswa, $id_game, $skor) {
        $this->db->query("
            INSERT INTO drag_drop_result (id_siswa, id_game, skor)
            VALUES (:siswa, :game, :skor)
        ");
        $this->db->bind(":siswa", $id_siswa);
        $this->db->bind(":game", $id_game);
        $this->db->bind(":skor", $skor);

        return $this->db->execute();
    }

    // ==========================
    // LEADERBOARD
    // ==========================
    public function getLeaderboard() {
        $this->db->query("
            SELECT s.nama_siswa, g.judul, r.skor, r.tanggal
            FROM drag_drop_result r
            JOIN siswa s ON s.id_siswa = r.id_siswa
            JOIN drag_drop_game g ON g.id_game = r.id_game
            ORDER BY r.skor DESC
        ");
        return $this->db->resultSet();
    }
}
