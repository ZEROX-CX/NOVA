<?php

class HasilTest extends Controllers
{
    public function index($id_mapel, $id_pertemuan)
    {
        if (!isset($_SESSION['id_siswa'])) {
            header('Location: ' . BASEURL . '/auth/login');
            exit;
        }

        $id_siswa = $_SESSION['id_siswa'];
        $preModel  = $this->model('Pretest_model');
        $postModel = $this->model('Posttest_model');
        $data['id_mapel'] = $id_mapel;
        // Ambil nilai dari database
        $nilai_pre_db  = $preModel->getNilai($id_siswa, $id_pertemuan);
        $nilai_post_db = $postModel->getNilai($id_siswa, $id_pertemuan);

        // --- Siapkan data Pre-Test untuk view ---
        $data_pre = []; // Default kosong
        if (!empty($nilai_pre_db)) {
            $questions_pre = $preModel->getSoalByPertemuan($id_pertemuan);
            $jumlah_pre = count($questions_pre);
            $nilai_pre = $nilai_pre_db['nilai'];
            // Hitung kembali jumlah jawaban benar dari nilai
            $benar_pre = round(($nilai_pre / 100) * $jumlah_pre);

            $data_pre = [
                'benar' => $benar_pre,
                'jumlah' => $jumlah_pre,
                'nilai' => number_format($nilai_pre, 2) // Format agar 2 angka di belakang koma
            ];
        }

        // --- Siapkan data Post-Test untuk view ---
        $data_post = []; // Default kosong
        if (!empty($nilai_post_db)) {
            $questions_post = $postModel->getSoalByPertemuan($id_pertemuan);
            $jumlah_post = count($questions_post);
            $nilai_post = $nilai_post_db['nilai'];
            // Hitung kembali jumlah jawaban benar dari nilai
            $benar_post = round(($nilai_post / 100) * $jumlah_post);

            $data_post = [
                'benar' => $benar_post,
                'jumlah' => $jumlah_post,
                'nilai' => number_format($nilai_post, 2) // Format agar 2 angka di belakang koma
            ];
        }

        // WAJIB: Cek apakah siswa sudah mengerjakan post-test
        // Jika belum, redirect ke halaman materi
        if (empty($data_post)) {
            // Anda bisa mengarahkan ke halaman materi atau post-test langsung
            header("Location: " . BASEURL . "/pertemuan/content/" . $id_pertemuan);
            exit;
        }

        $data = [
            "judul"         => "Hasil Test",
            "id_pertemuan"  => $id_pertemuan,
            "pre"           => $data_pre,
            "post"          => $data_post,
            "id_mapel"      => $id_mapel
        ];

        $this->view('templates/navbar', $data);
        $this->view('hasiltest/index', $data);
    }
}