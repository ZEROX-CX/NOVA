<?php

class TruefalseModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // ambil atau create game guru
    public function getOrCreateGame($id_guru)
    {
        $q = $this->db->query("SELECT * FROM true_false_game WHERE id_guru=? LIMIT 1", [$id_guru]);
        $row = $this->$q->fetch();

        if ($row) return $row;

        // create
        $this->db->query("INSERT INTO true_false_game (id_guru, judul) VALUES (?, 'Game True/False Saya')",
            [$id_guru]
        );

        $id = $this->db->lastId();

        return [
            'id_game' => $id,
            'judul' => 'Game True/False Saya'
        ];
    }

    public function getQuestions($id_game)
    {
        $q = $this->db->query("SELECT * FROM true_false_question WHERE id_game=? ORDER BY RAND()", [$id_game]);
        return $q->fetchAll();
    }

    public function addQuestion($data)
    {
        $this->db->query(
            "INSERT INTO true_false_question (id_game, pertanyaan, jawaban) VALUES (?, ?, ?)",
            [$data['id_game'], $data['pertanyaan'], $data['jawaban']]
        );
    }

    public function updateQuestion($data)
    {
        $this->db->query(
            "UPDATE true_false_question SET pertanyaan=?, jawaban=? WHERE id_question=?",
            [$data['pertanyaan'], $data['jawaban'], $data['id_question']]
        );
    }

    public function deleteQuestion($id)
    {
        $this->db->query("DELETE FROM true_false_question WHERE id_question=?", [$id]);
    }

    public function saveScore($id_siswa, $id_game, $skor)
    {
        $this->db->query(
            "INSERT INTO true_false_result (id_siswa, id_game, skor) VALUES (?, ?, ?)",
            [$id_siswa, $id_game, $skor]
        );
    }

    public function getLeaderboard($id_game)
    {
        $q = $this->db->query(
            "SELECT s.nama, r.skor, r.waktu
             FROM true_false_result r
             JOIN siswa s ON r.id_siswa = s.id_siswa
             WHERE r.id_game=?
             ORDER BY r.skor DESC",
            [$id_game]
        );

        return $this->$q->fetchAll();
    }
}
