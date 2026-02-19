<?php

class Dashboard extends Controllers {
    public function index($params = null)
    {
        // ... (kode index tidak berubah)
        $kelas = null;
        if (isset($_GET['kelas']) && $_GET['kelas'] !== '') {
            $kelas = $_GET['kelas'];
        } elseif (!empty($params)) {
            $kelas = $params;
        }

        $search = null;
        if (isset($_GET['cari']) && $_GET['cari'] !== '') {
            $search = $_GET['cari'];
        }

        $model = $this->model('Dashboard_model');
        if ($search && $kelas) {
            $data['siswa'] = $model->getSiswaByKelasAndNama($kelas, $search);
        } elseif ($search) {
            $data['siswa'] = $model->getSiswaByNama($search);
        } elseif ($kelas) {
            $data['siswa'] = $model->getSiswaByKelas($kelas);
        } else {
            $data['siswa'] = $this->model('Dashboard_model')->getAllSiswa();
            $data['kelas'] = '';
        }

        $data['kelas'] = $kelas ?? '';
        $data['search'] = $search ?? '';

        $data['judul'] = 'Dashboard';
        $this->view('templates/navbar', $data);
        $this->view('dashboard/index', $data);
    }

    public function mapel($id_mapel, $params = null)
    {
        $data['judul'] = 'Dasboard';
        $kelas = null;
        if (isset($_GET['kelas']) && $_GET['kelas'] !== '') {
            $kelas = $_GET['kelas'];
        } elseif (!empty($params)) {
            $kelas = $params;
        }

        $search = null;
        if (isset($_GET['cari']) && $_GET['cari'] !== '') {
            $search = $_GET['cari'];
        }

        $status = null;
        if(isset($_GET['status']) && $_GET['status'] !== '') {
            $status = $_GET['status'];
        } elseif(!empty($params)) {
            $status = $params;
        }

        $model = $this->model('Dashboard_model');
        if ($search && $kelas) {
            $data['siswa'] = $model->getSiswaByKelasAndNama($kelas, $search);
        } elseif ($search) {
            $data['siswa'] = $model->getSiswaByNama($search);
        } elseif ($kelas) {
            // Perbaikan: Memanggil fungsi yang benar dari model
            $data['siswa'] = $model->getSiswaByKelasAndMapel($kelas, $id_mapel);
        } elseif ($status) {
            // Perbaikan: Memanggil fungsi yang benar dari model
            $data['siswa'] = $model->getSiswaByStatusAndMapel($status, $id_mapel);
        } else {
            $data['siswa'] = $model->getSiswaByMapel($id_mapel);
        }

        // BARU: Siapkan daftar siswa yang bisa ditambahkan ke mapel ini
        $data['siswa_tersedia'] = $model->getSiswaNotInMapel($id_mapel);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_mapel);
        $data['kelas'] = $kelas ?? '';
        $data['search'] = $search ?? '';
        $data['id_mapel'] = $id_mapel;
        $this->view('templates/navbar', $data);
        $this->view('dashboard/mapel', $data);
    }

    public function test()
    {
        $data['mapel'] = $this->model('Dashboard_model')->getMapelByGuru();
        $this->view('templates/navbar');
        $this->view('dashboard/test', $data);
    }

    public function pertemuan($id_mapel) {
        $data['judul'] = 'Pertemuan';
        $data['materi'] = $this->model('Mapel_guru_model')->getMateriById($id_mapel);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_mapel);
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanByMateri($id_mapel);
        $data['mapel_list'] = $this->model('Mapel_guru_model')->getAllMapelList();

        $this->view('templates/navbar', $data);
        $this->view('dashboard/pertemuan', $data);
    }

    public function pertemuan_content($id_materi, $id_pertemuan)
    {

        // sekan meambil data dari database
        $data['judul'] = 'Pertemuan';
        $data['pretest'] = $this->model('Pertemuan_model')->getPretestById($id_pertemuan);
        $data['sesi_absen'] = $this->model('Pertemuan_model')->getSesiByPertemuan($id_pertemuan);
        $data['id_pertemuan'] = $id_pertemuan;
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['tugas'] = $this->model('Pertemuan_model')->getTugasByPertemuan($id_pertemuan);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_materi);
        $data['refleksi'] = $this->model('Pertemuan_model')->getRefleksiByPertemuan($id_pertemuan);
        $data['sudah_absen'] = !empty($kehadiran);
        $data['materi'] = $this->model('Pertemuan_model')->getMateriByPertemuan($id_pertemuan);

        $this->view('templates/navbar', $data);
        $this->view('dashboard/pertemuan_content', $data);
    }

public function editAbsen()
{
    $id_pertemuan = $_POST['idPertemuan'] ?? null;
    $tanggalAbsen = $_POST['tanggalAbsen'] ?? null;
    
    $this->model('Absen_model')->editAbsen($id_pertemuan, $tanggalAbsen);
    
    header('Location: ' . BASEURL . '/dashboard/pertemuan_content/' . $id_pertemuan);
}   


    // PERUBAHAN: Sesuaikan method tambah
    public function tambah()
    {
        $id_mapel = $_POST['id_mapel'] ?? null;
        $id_siswa = $_POST['id_siswa'] ?? null;

        if($id_siswa && $id_mapel) {
            $result = $this->model("Dashboard_model")->tambahSiswaKeMapel($id_siswa, $id_mapel);
            
            if($result) {
                // Berhasil ditambahkan
                echo 'Berhasil', 'siswa ditambahkan ke mapel', 'success';
            } else {
                // Gagal, kemungkinan besar karena siswa sudah ada
                echo 'Gagal', 'siswa sudah ada di mata pelajaran ini', 'danger';
            }
        } else {
            echo 'Gagal', 'data tidak lengkap', 'danger';
        }

        // Redirect ke halaman mapel yang sama
        $redirect_url = BASEURL . '/dashboard/mapel/' . $id_mapel;
        header("Location: " . $redirect_url);
        exit;
    }

    public function searchSiswa()
    {
        $id_mapel = $_GET['id_mapel'] ?? null;
        $query = $_GET['query'] ?? null;
        
        // Debug: Log parameter yang diterima
        error_log("searchSiswa called with id_mapel: $id_mapel, query: $query");
        
        if ($id_mapel && $query && strlen($query) >= 2) {
            $results = $this->model('Dashboard_model')->searchSiswaNotInMapel($id_mapel, $query);
            
            // Debug: Log hasil query
            error_log("Results: " . print_r($results, true));
            
            header('Content-Type: application/json');
            echo json_encode($results);
        } else {
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    }

}