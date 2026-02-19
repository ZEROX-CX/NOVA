<?php

class Pertemuan extends Controllers {
    
    public function index($id_mapel) {
        $data['judul'] = 'Pertemuan';
        $data['materi'] = $this->model('Mapel_guru_model')->getMateriById($id_mapel);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_mapel);
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanByMateri($id_mapel);
        $data['mapel_list'] = $this->model('Mapel_guru_model')->getAllMapelList();

        $this->view('templates/navbar', $data);
        $this->view('pertemuan/index', $data);
    }

    public function hapus($id_pertemuan = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('HTTP/1.1 405 Method Not Allowed');
            echo 'Method Not Allowed';
            exit;
        }

        if (empty($id_pertemuan)) {
            $_SESSION['flash_message'] = 'ID pertemuan tidak diberikan.';
            $_SESSION['message_type'] = 'error';
            header('Location: ' . BASEURL);
            exit;
        }

        $model = $this->model('Pertemuan_model');
        $pertemuan = $model->getPertemuanById($id_pertemuan);
        if (!$pertemuan) {
            $_SESSION['flash_message'] = 'Pertemuan tidak ditemukan.';
            $_SESSION['message_type'] = 'error';
            header('Location: ' . BASEURL);
            exit;
        }

        $id_mapel = $pertemuan['id_mapel'];
        $ok = $model->hapusPertemuan($id_pertemuan);

        if ($ok) {
            $_SESSION['flash_message'] = '✅ Pertemuan berhasil dihapus.';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = '❌ Gagal menghapus pertemuan. Silakan coba lagi.';
            $_SESSION['message_type'] = 'error';
        }

        header('Location: ' . BASEURL . '/dashboard/pertemuan/' . $id_mapel);
        exit;
    }

    // Hapus hanya daftar hadir (absen + sesi)
    public function hapus_absen($id_mapel = null, $id_pertemuan = null)
    {
        if (empty($id_pertemuan)) {
            $_SESSION['flash_message'] = 'ID pertemuan tidak diberikan.';
            $_SESSION['message_type'] = 'error';
            header('Location: ' . BASEURL); exit;
        }
        $model = $this->model('Pertemuan_model');
    
        $mapel = $model->getPertemuanById($id_mapel);
        if (!$mapel) {
            $_SESSION['flash_message'] = 'Pertemuan tidak ditemukan.';
            $_SESSION['message_type'] = 'error';
            header('Location: ' . BASEURL); exit;
        }
        $ok = $model->hapusAbsenByPertemuan($id_pertemuan);
        $_SESSION['flash_message'] = $ok ? '✅ Daftar hadir dihapus.' : '❌ Gagal menghapus daftar hadir.';
        $_SESSION['message_type'] = $ok ? 'success' : 'error';
        header('Location: ' . BASEURL . '/dashboard/pertemuan/' . $mapel['id_mapel']); exit;
    }

    // Hapus tugas saja
    public function hapus_tugas($id_pertemuan = null)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('HTTP/1.1 405 Method Not Allowed'); exit; }
        if (empty($id_pertemuan)) { $_SESSION['flash_message'] = 'ID pertemuan tidak diberikan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $model = $this->model('Pertemuan_model');
        $pertemuan = $model->getPertemuanById($id_pertemuan);
        if (!$pertemuan) { $_SESSION['flash_message']='Pertemuan tidak ditemukan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $ok = $model->hapusTugasByPertemuan($id_pertemuan);
        $_SESSION['flash_message'] = $ok ? '✅ Semua tugas dihapus.' : '❌ Gagal menghapus tugas.';
        $_SESSION['message_type'] = $ok ? 'success' : 'error';
        header('Location: ' . BASEURL . '/dashboard/pertemuan/' . $pertemuan['id_mapel']); exit;
    }

    // Hapus materi (dan pre/post test)
    public function hapus_materi($id_pertemuan = null)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('HTTP/1.1 405 Method Not Allowed'); exit; }
        if (empty($id_pertemuan)) { $_SESSION['flash_message']='ID pertemuan tidak diberikan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $model = $this->model('Pertemuan_model');
        $pertemuan = $model->getPertemuanById($id_pertemuan);
        if (!$pertemuan) { $_SESSION['flash_message']='Pertemuan tidak ditemukan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $ok = $model->hapusMateriByPertemuan($id_pertemuan);
        $_SESSION['flash_message'] = $ok ? '✅ Materi dan pre/post-test dihapus.' : '❌ Gagal menghapus materi.';
        $_SESSION['message_type'] = $ok ? 'success' : 'error';
        header('Location: ' . BASEURL . '/dashboard/pertemuan/' . $pertemuan['id_mapel']); exit;
    }

    // Hapus refleksi
    public function hapus_refleksi($id_pertemuan = null)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('HTTP/1.1 405 Method Not Allowed'); exit; }
        if (empty($id_pertemuan)) { $_SESSION['flash_message']='ID pertemuan tidak diberikan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $model = $this->model('Pertemuan_model');
        $pertemuan = $model->getPertemuanById($id_pertemuan);
        if (!$pertemuan) { $_SESSION['flash_message']='Pertemuan tidak ditemukan.'; $_SESSION['message_type']='error'; header('Location: '.BASEURL); exit; }
        $ok = $model->hapusRefleksiByPertemuan($id_pertemuan);
        $_SESSION['flash_message'] = $ok ? '✅ Refleksi dihapus.' : '❌ Gagal menghapus refleksi.';
        $_SESSION['message_type'] = $ok ? 'success' : 'error';
        header('Location: ' . BASEURL . '/dashboard/pertemuan/' . $pertemuan['id_mapel']); exit;
    }

    public function tambah($id_materi = null) {
        $data['judul'] = 'Tambah Pertemuan';
        $data['id_materi'] = $id_materi;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = $this->model("Pertemuan_model");

            // Validasi dasar
            if (empty($_POST['id_mapel'])) {
                echo 'ID Mapel tidak ditemukan', 'danger';
                header("Location: " . BASEURL . "/dashboard/pertemuan/" . $id_materi);
                exit;
            }

            if (empty($_POST['judul_pertemuan'])) {
                echo 'Judul pertemuan harus diisi', 'danger';
                header("Location: " . BASEURL . "/dashboard/pertemuan/" . $id_materi);
                exit;
            }

            // 1. Tambah pertemuan utama
            $id_pertemuan = $model->tambahPertemuan($_POST);

            if (!$id_pertemuan) {
                echo 'Gagal menambahkan pertemuan', 'danger';
                header("Location: " . BASEURL . "/pertemuan/" . $_POST['id_mapel']);
                exit;
            }

            // 2. Tambah sesi absen
            $sesi_data = ['id_pertemuan' => $id_pertemuan];
            if (!empty($_POST['tanggal_sesi'])) {
                $sesi_data['tanggal_sesi'] = $_POST['tanggal_sesi'];
            }
            
            $sesi_result = $model->tambahSesiAbsen($sesi_data);
            
            // 3. Tambah Pre-Test jika ada
            $hasPretest = false;
            $pretestData = [];
            $i = 1;
            while (isset($_POST["pre_pertanyaan_$i"])) {
                if (!empty($_POST["pre_pertanyaan_$i"])) {
                    $hasPretest = true;
                    $pretestData[] = [
                        'id_pertemuan' => $id_pertemuan,
                        'pertanyaan'   => $_POST["pre_pertanyaan_$i"],
                        'opsi_a'       => $_POST["pre_a_$i"] ?? '',
                        'opsi_b'       => $_POST["pre_b_$i"] ?? '',
                        'opsi_c'       => $_POST["pre_c_$i"] ?? '',
                        'opsi_d'       => $_POST["pre_d_$i"] ?? '',
                        'jawaban_benar'=> $_POST["pre_jawaban_benar_$i"] ?? ''
                    ];
                }
                $i++;
            }
            if ($hasPretest && !empty($pretestData)) {
                $model->tambahMultiplePreTest($pretestData);
            }

            // 4. Tambah Post-Test jika ada
            $hasPosttest = false;
            $postData = [];
            $i = 1;
            while (isset($_POST["post_pertanyaan_$i"])) {
                if (!empty($_POST["post_pertanyaan_$i"])) {
                    $hasPosttest = true;
                    $postData[] = [
                        'id_pertemuan' => $id_pertemuan,
                        'pertanyaan'   => $_POST["post_pertanyaan_$i"],
                        'opsi_a'       => $_POST["post_a_$i"] ?? '',
                        'opsi_b'       => $_POST["post_b_$i"] ?? '',
                        'opsi_c'       => $_POST["post_c_$i"] ?? '',
                        'opsi_d'       => $_POST["post_d_$i"] ?? '',
                        'jawaban_benar'=> $_POST["post_jawaban_benar_$i"] ?? ''
                    ];
                }
                $i++;
            }
            if ($hasPosttest && !empty($postData)) {
                $model->tambahMultiplePostTest($postData);
            }
            // 5. Tambah Refleksi jika ada
            $hasRefleksi = false;
            $RefleksiData = [];
            $i = 1;
            while (isset($_POST["refleksi_pertanyaan_$i"])) {
                if (!empty($_POST["refleksi_pertanyaan_$i"])) {
                    $hasRefleksi = true;
                    $RefleksiData[] = [
                        'id_pertemuan' => $id_pertemuan,
                        'pertanyaan'   => $_POST["refleksi_pertanyaan_$i"],
                    ];
                }
                $i++;
            }
            if ($hasRefleksi && !empty($RefleksiData)) {
                $model->tambahMultipleRefleksi($RefleksiData);
            }

            // 5. Tambah materi jika ada
            if (!empty($_POST['materi']) || !empty($_FILES['materi_file']['name']) || !empty($_POST['link_youtube'])) {
                $model->tambahMateri([
                    'id_pertemuan' => $id_pertemuan,
                    'teks'         => $_POST['materi'],
                    'file'         => $_FILES['materi_file'],
                    'link_youtube' => $_POST['link_youtube']
                ]);
            }

            // 6. Tambah tugas jika ada
            if (!empty($_POST['tugas']) || !empty($_FILES['tugas_file']['name'])) {
                $model->tambahTugas([
                    'id_pertemuan' => $id_pertemuan,
                    'teks'         => $_POST['tugas'],
                    'file'         => $_FILES['tugas_file'],
                    'deadline'     => $_POST['deadline'] ?? null,
                    'allow_late'   => $_POST['allow_late'] ?? 0
                ]);
            }

            // 7. Set flash message berdasarkan hasil
            if ($sesi_result) {
                echo '✅ Pertemuan dan sesi absen berhasil ditambahkan!', 'success';
            } else {
                echo'⚠️ Pertemuan berhasil ditambah, tapi sesi absen gagal dibuat', 'warning';
            }

            header("Location: " . BASEURL . "/dashboard/pertemuan/" . $_POST['id_mapel']);
            exit;
        }

        $this->view('templates/navbar', $data);
        $this->view('pertemuan/tambah', $data);
    }
}