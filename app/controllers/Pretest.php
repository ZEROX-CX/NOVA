<?php

class Pretest extends Controllers
{
    public function index($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['judul'] = 'Pre-Test';
        $data['id_pertemuan'] = $id_pertemuan;

        // Ambil semua soal pretest untuk pertemuan ini
        $data['questions'] = $this->model('Pretest_model')->getSoalByPertemuan($id_pertemuan);

        $this->view('templates/navbar', $data);
        $this->view('pretest/index', $data);
    }

    public function submit()
    {
        $id_pertemuan = $_POST['id_pertemuan'];
        $id_mapel = $_POST['id_mapel'];
        $id_siswa = $_SESSION['id_siswa'];
        $tab_switch_count = isset($_POST['tab_switch_count']) ? $_POST['tab_switch_count'] : 0;
        $test_duration = isset($_POST['test_duration']) ? $_POST['test_duration'] : 0;

        $model = $this->model('Pretest_model');
        $questions = $model->getSoalByPertemuan($id_pertemuan);

        $benar = 0;
        $jumlah = count($questions);

        foreach ($questions as $q) {
            $qid = $q['id_pretest'];
            $kunci = $q['jawaban_benar'];

            // Gunakan trim() untuk membersihkan jawaban dari spasi
            $jawaban_user = isset($_POST["soal_$qid"]) ? trim($_POST["soal_$qid"]) : '';

            if ($jawaban_user === trim($kunci)) {
                $benar++;
            }
        }

        $nilai = ($jumlah > 0) ? ($benar / $jumlah) * 100 : 0;
        $nilai = round($nilai, 2);

        // Simpan nilai dengan data tambahan
        $model->simpanNilai($id_siswa, $id_pertemuan, $nilai, $tab_switch_count, $test_duration);

        // Setelah pre-test → langsung ke materi
        header("Location: " . BASEURL . "/materi/" . $id_mapel . "/" . $id_pertemuan);
        exit;
    }

    public function create($id_mapel, $id_pertemuan)
    {

        $data['id_mapel'] = $id_mapel;
        $data['judul'] = 'Tambah Soal Pre-Test';
        $data['id_pertemuan'] = $id_pertemuan;
        $this->view('pretest/create', $data);
    }

        public function edit($id_pretest)
    {
        // Pastikan hanya guru yang bisa akses
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        $model = $this->model('Pretest_model');
        $data['soal'] = $model->getSoalById($id_pretest);
        $data['judul'] = 'Edit Soal Pre-Test';
        $this->view('pretest/edit', $data);
    }

    public function store()
    {
        // Pastikan hanya guru yang bisa akses
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

            $this->model('Pretest_model')->tambahSoal($data);
            header("Location: " . BASEURL . "/guru/pretest/" . $id_mapel . "/" . $id_pertemuan);
            exit;
        }
    }

    public function update()
    {
        // Pastikan hanya guru yang bisa akses
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pretest = $_POST['id_pretest'];
            $id_pertemuan = $_POST['id_pertemuan'];
            $data = [
                'pertanyaan' => $_POST['pertanyaan'],
                'opsi_a' => $_POST['opsi_a'],
                'opsi_b' => $_POST['opsi_b'],
                'opsi_c' => $_POST['opsi_c'],
                'opsi_d' => $_POST['opsi_d'],
                'jawaban_benar' => $_POST['jawaban_benar']
            ];

            $this->model('Pretest_model')->updateSoal($id_pretest, $data);
            header("Location: " . BASEURL . "/guru/pretest/" . $id_pertemuan);
            exit;
        }
    }

    public function delete($id_pretest)
    {
        // Pastikan hanya guru yang bisa akses
        if (!isset($_SESSION['id_guru'])) {
            header('Location: ' . BASEURL . '/login_guru');
            exit;
        }

        // Ambil id_pertemuan sebelum menghapus untuk redirect
        $model = $this->model('Pretest_model');
        $soal = $model->getSoalById($id_pretest);
        $id_pertemuan = $soal['id_pertemuan'];

        $model->deleteSoal($id_pretest);
        header("Location: " . BASEURL . "/guru/pretest/" . $id_pertemuan);
        exit;
    }
}