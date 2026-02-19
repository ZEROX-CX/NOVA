<?php

class Posttest extends Controllers {
    public function index($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['judul'] = 'Post-Test';
        $data['id_pertemuan'] = $id_pertemuan;

        // Ambil semua soal posttest untuk pertemuan ini
        $data['questions'] = $this->model('Posttest_model')->getSoalByPertemuan($id_pertemuan);

        $this->view('templates/navbar', $data);
        $this->view('posttest/index', $data);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASEURL . "/pertemuan");
            exit;
        }

        $id_pertemuan = $_POST['id_pertemuan'];
        $id_siswa = $_SESSION['id_siswa'];
        $id_mapel = $_POST['id_mapel'];

        $questions = $this->model('Posttest_model')->getSoalByPertemuan($id_pertemuan);

        $benar = 0;
        $jumlah = count($questions);

        foreach ($questions as $q) {
            $qid = $q['id_posttest'];
            $kunci = $q['jawaban_benar'];

            // Gunakan trim() untuk membersihkan jawaban dari spasi
            $jawaban_user = isset($_POST["soal_$qid"]) ? trim($_POST["soal_$qid"]) : '';

            if ($jawaban_user === trim($kunci)) {
                $benar++;
            }
        }

        $nilai = ($jumlah > 0) ? ($benar / $jumlah) * 100 : 0;
        $nilai = round($nilai, 2);

        // Simpan nilai
        $this->model('Posttest_model')->simpanNilai($id_siswa, $id_pertemuan, $nilai);

        // Setelah post-test → ke halaman hasil test
        header("Location: " . BASEURL . "/hasiltest/" . $id_mapel . "/" . $id_pertemuan);
        exit;
    }

    public function create($id_mapel, $id_pertemuan)
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        $data['id_mapel'] = $id_mapel;
        $data['judul'] = 'Tambah Soal Post-Test';
        $data['id_pertemuan'] = $id_pertemuan;
        
        $this->view('templates/navbar', $data);
        $this->view('posttest/create', $data);
    }

    public function edit($id_posttest)
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        $model = $this->model('Posttest_model');
        $data['soal'] = $model->getSoalById($id_posttest);
        $data['judul'] = 'Edit Soal Post-Test';
        
        $this->view('templates/navbar', $data);
        $this->view('posttest/edit', $data);
    }

    public function store()
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pertemuan = $_POST['id_pertemuan'];
            $id_mapel = $_POST['id_mapel'];
            $data = [
                'id_pertemuan' => $id_pertemuan,
                'pertanyaan' => $_POST['pertanyaan'],
                'opsi_a' => $_POST['opsi_a'],
                'opsi_b' => $_POST['opsi_b'],
                'opsi_c' => $_POST['opsi_c'],
                'opsi_d' => $_POST['opsi_d'],
                'jawaban_benar' => $_POST['jawaban_benar']
            ];

            $this->model('Posttest_model')->tambahSoal($data);
            header("Location: " . BASEURL . "/guru/posttest/" . $id_mapel . "/" . $id_pertemuan);
            exit;
        }
    }

    public function update()
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_posttest = $_POST['id_posttest'];
            $id_pertemuan = $_POST['id_pertemuan'];
            $data = [
                'pertanyaan' => $_POST['pertanyaan'],
                'opsi_a' => $_POST['opsi_a'],
                'opsi_b' => $_POST['opsi_b'],
                'opsi_c' => $_POST['opsi_c'],
                'opsi_d' => $_POST['opsi_d'],
                'jawaban_benar' => $_POST['jawaban_benar']
            ];

            $this->model('Posttest_model')->updateSoal($id_posttest, $data);
            header("Location: " . BASEURL . "/guru/posttest/" . $id_pertemuan);
            exit;
        }
    }

    public function delete($id_posttest)
    {
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        $model = $this->model('Posttest_model');
        $soal = $model->getSoalById($id_posttest);
        $id_pertemuan = $soal['id_pertemuan'];

        $model->deleteSoal($id_posttest);
        header("Location: " . BASEURL . "/guru/posttest/" . $id_pertemuan);
        exit;
    }
}