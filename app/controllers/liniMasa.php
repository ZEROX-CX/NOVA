<?php

class liniMasa extends Controllers{
    public function index()
    {
        $data['judul'] = 'Linimasa';
        $id_siswa = $_SESSION['id_siswa'] ?? '';
        if (isset($_POST['cari'])) {
            $searchTerm = $_POST['search'] ?? '';
            $data['linimasa'] = $this->model('liniMasa_model')->searchTugasAndAbsen($searchTerm);
            
        } else {
            $data['absen'] = $this->model('liniMasa_model')->getBelumAbsensi();
            $data['mapel'] = $this->model('Mapel_guru_model')->getAllMapel();
            $data['tugas'] = $this->model('linimasa_model')->getAllTugas();
            $data['cek'] = $this->model('linimasa_model')->getTugasBelumDikumpulkan($id_siswa);
        }

        $this->view('templates/navbar', $data);
        $this->view('liniMasa/index', $data);
        // $this->view('templates/footer');
    }
}
