<?php

class Truefalse extends Controllers
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model("TruefalseModel");
    }

    // ===========================
    //   HALAMAN GURU (ADMIN)
    // ===========================
    public function admin()
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $id_guru = $_SESSION['id_guru'];

        // pastikan game sudah ada
        $game = $this->model->getGameByTeacher($id_guru);

        if (!$game) {
            $this->model->createGame($id_guru, "Game Pertama Saya");
            $game = $this->model->getGameByTeacher($id_guru);
        }

        $questions = $this->model->getQuestions($game['id_game']);

        $this->view('truefalse/admin', [
            'game' => $game,
            'questions' => $questions
        ]);
    }

    // TAMBAH
    public function tambah()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if ($_SESSION['role'] !== 'guru') return;

        $this->model->addQuestion($_POST['id_game'], $_POST['pertanyaan'], $_POST['jawaban']);

        header("Location: " . BASEURL . "/Truefalse/admin");
    }

    // UBAH
    public function ubah()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if ($_SESSION['role'] !== 'guru') return;

        $this->model->updateQuestion($_POST['id_question'], $_POST['pertanyaan'], $_POST['jawaban']);

        header("Location: " . BASEURL . "/Truefalse/admin");
    }

    // HAPUS
    public function hapus($id)
    {
        if ($_SESSION['role'] !== 'guru') return;

        $this->model->deleteQuestion($id);

        header("Location: " . BASEURL . "/Truefalse/admin");
    }

    // ===========================
    //        HALAMAN SISWA
    // ===========================
    public function index($id_game)
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
            header('Location: ' . BASEURL . '/login');
            exit;
        }

        $questions = $this->model->getQuestions($id_game);

        $this->view('truefalse/index', [
            'questions' => $questions,
            'id_game' => $id_game
        ]);
    }

    // ===========================
    //      SIMPAN SKOR
    // ===========================
    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if ($_SESSION['role'] !== 'siswa') return;

        $this->model->saveScore(
            $_SESSION['id_siswa'],
            $_POST['id_game'],
            $_POST['skor']
        );

        echo "OK";
    }

    // ===========================
    //       LEADERBOARD
    // ===========================
    public function leaderboard($id_game)
    {
        $list = $this->model->getLeaderboard($id_game);

        $this->view('truefalse/leaderboard', [
            'list' => $list,
            'id_game' => $id_game]);
    }
}
