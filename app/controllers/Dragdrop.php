<?php

class Dragdrop extends Controllers
{
    private $model;

    public function __construct()
    {
        $this->model = $this->model('Dragdrop_model');
    }

    /* ===========================
       HALAMAN MAIN GAME
       =========================== */
    public function index()
    {
        $data['judul'] = 'drag&drop';
        $data['games'] = $this->model->getAllGames();
        $this->view('templates/navbar', $data);
        $this->view('dragdrop/index', $data);
    }

    /* ===========================
       GET JSON DATA UNTUK GAME
       =========================== */
    public function getdata()
    {
        $id_game = $_GET['id_game'] ?? null;

        if (!$id_game) {
            echo json_encode(["error" => "id_game missing"]);
            return;
        }

        $data = $this->model->getGameData($id_game);
        echo json_encode($data);
    }

    /* ===========================
       SIMPAN SKOR SISWA
       =========================== */
    public function save()
    {
        $json = file_get_contents("php://input");
        $body = json_decode($json, true);

        if (!$body) {
            echo json_encode(["status" => "error", "message" => "Invalid JSON"]);
            return;
        }

        $this->model->saveScore(
            $body["id_siswa"],
            $body["id_game"],
            $body["score"]
        );

        echo json_encode(["status" => "ok"]);
    }

    /* ===========================
       LEADERBOARD
       =========================== */
    public function leaderboard()
    {
        $data['judul'] = 'leaderboard';
        $data['scores'] = $this->model->getLeaderboard();
        $this->view('templates/navbar', $data);
        $this->view("dragdrop/leaderboard", $data);
    }


    /* ===========================
       HALAMAN ADMIN
       =========================== */
    public function admin()
    {
        // DELETE GAME
        if (isset($_GET['delete'])) {
            $this->model->deleteGame($_GET['delete']);
            header("Location: " . BASEURL . "/Dragdrop/admin");
            exit;
        }

        // ADD GAME
        if (isset($_POST['add_game'])) {
            $this->model->createGame($_POST['judul'], $_SESSION['id_guru']);
            header("Location: " . BASEURL . "/Dragdrop/admin");
            exit;
        }

        // EDIT GAME NAME
        if (isset($_POST['edit_game'])) {
            $this->model->updateGame($_POST['id_game'], $_POST['judul']);
            header("Location: " . BASEURL . "/Dragdrop/admin");
            exit;
        }


        /* =====================
           CRUD AREA DROP
           ===================== */

        // ADD AREA
        if (isset($_POST['add_area'])) {
            $this->model->createArea($_POST['id_game'], $_POST['nama_area']);
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $_POST['id_game']);
            exit;
        }

        // EDIT AREA
        if (isset($_POST['edit_area'])) {
            $this->model->updateArea($_POST['id_area'], $_POST['nama_area']);
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $_POST['id_game']);
            exit;
        }

        // DELETE AREA
        if (isset($_GET['delete_area'])) {
            $id_area = $_GET['delete_area'];
            $id_game = $_GET['id_game'];

            $this->model->deleteArea($id_area);
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $id_game);
            exit;
        }


        /* =====================
           CRUD ITEM
           ===================== */

        // ADD ITEM
        if (isset($_POST['add_item'])) {
            $this->model->createItem(
                $_POST['id_game'],
                $_POST['nama_item'],
                $_POST['correct_area_id']
            );
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $_POST['id_game']);
            exit;
        }

        // EDIT ITEM
        if (isset($_POST['edit_item'])) {
            $this->model->updateItem(
                $_POST['id_item'],
                $_POST['nama_item'],
                $_POST['correct_area_id']
            );
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $_POST['id_game']);
            exit;
        }

        // DELETE ITEM
        if (isset($_GET['delete_item'])) {
            $id_item = $_GET['delete_item'];
            $id_game = $_GET['id_game'];

            $this->model->deleteItem($id_item);
            header("Location: " . BASEURL . "/Dragdrop/admin?open=" . $id_game);
            exit;
        }



        /* =====================
           RENDER ADMIN PAGE
           ===================== */

        $data['games'] = $this->model->getAllGames();

        // Jika membuka 1 game untuk mengedit area + item
        if (isset($_GET['open'])) {
            $id = $_GET['open'];
            $data['open'] = $this->model->getGameData($id);
        }
        $data['judul'] = 'admin';
        $this->view('templates/navbar', $data);
        $this->view("dragdrop/admin", $data);
    }
}
