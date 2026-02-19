<?php

class Dnd extends Controllers
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Drag_drop_model');

        // Cek login

        $role = $_SESSION['role'];

        // Ambil method yang dipanggil
        $url = $_GET['url'] ?? 'dnd/index';
        $parts = explode('/', $url);
        $method = $parts[1] ?? 'index';

        // Method yang boleh untuk siswa
        $allowedForSiswa = ['index', 'leaderboard', 'getdata', 'save'];

        // Jika siswa & method tidak diizinkan → redirect
    }

    public function index()
    {
        if ($_SESSION['role'] !== 'siswa') {
            // Guru bisa membuka index untuk testing
            // Jika ingin redirect guru ke admin, ubah ke:
            // header('Location: ' . BASEURL . '/Dragdrop/admin');
        }

        $data['games'] = $this->model->getAllGames();
        $this->view('dnd/index', $data);
    }

    public function getdata()
    {
        header('Content-Type: application/json');

        $id = $_GET['id_game'] ?? null;

        if (!$id) {
            echo json_encode(['error' => 'Missing id_game']);
            return;
        }

        $data = $this->model->getGameData($id);
        echo json_encode($data);
    }

    public function save()
    {
        header('Content-Type: application/json');
        $input = json_decode(file_get_contents('php://input'), true);

        $this->model->saveScore(
            $input['id_siswa'],
            $input['id_game'],
            $input['score']
        );

        echo json_encode(['status' => 'ok']);
    }

    public function leaderboard()
    {
        $scores = $this->model->getLeaderboard();
        $this->view('dnd/leaderboard', ['scores' => $scores]);
    }

    // --- Tambahan method Admin yang hanya untuk guru ---
    
    public function admin()
    {
        if ($_SESSION['role'] !== 'guru') {
            header('Location: ' . BASEURL . '/d&d/index');
            exit;
        }

        $data['games'] = $this->model->getAllGames();
        $this->view('dnd/admin', $data);
    }
}
