<?php

class Guru extends Controllers {
    public function pretest($id_mapel, $id_pertemuan)
    {
        $data['id_pertemuan'] = $id_pertemuan;
        $data['id_mapel'] = $id_mapel;
        $data['questions'] = $this->model('Pretest_model')->getSoalByPertemuan($id_pertemuan);
        $this->view('templates/navbar');
        $this->view('guru/pretest', $data);
    }

    public function nilai_pretest($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $model = $this->model('Pretest_model');
        $data['siswa'] = $model->getNilaiByPretest($id_pertemuan);
        $data['id_pertemuan'] = $id_pertemuan;
        
        // Debug: uncomment untuk melihat data
        // var_dump($data['siswa']);
        
        $this->view('templates/navbar');
        $this->view('guru/nilai_pretest', $data);
    }

    public function nilai_posttest($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;
        $model = $this->model('Posttest_model');
        $data['siswa'] = $model->getNilaiByPosttest($id_pertemuan);
        $this->view('templates/navbar');
        $this->view('guru/nilai_posttest', $data);
    }

    public function materi($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['materi'] = $this->model('Pertemuan_model')->getMateriByPertemuan($id_pertemuan);
        $this->view('templates/navbar');
        $this->view('guru/materi', $data);   
    }

    public function posttest($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['judul'] = 'Post-Test';
        $data['id_pertemuan'] = $id_pertemuan;

        // Ambil semua soal posttest untuk pertemuan ini
        $data['questions'] = $this->model('Posttest_model')->getSoalByPertemuan($id_pertemuan);

        $this->view('templates/navbar', $data);
        $this->view('guru/posttest', $data);
    }

    public function refleksi($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['refleksi'] = $this->model('Pertemuan_model')->getRefleksiByPertemuan($id_pertemuan);
        $this->view("templates/navbar", $data);
        $this->view("guru/refleksi", $data);
    }

    public function tugas($id_mapel, $id_pertemuan)
    {
        $data['id_mapel'] = $id_mapel;
        $data['id_pertemuan'] = $id_pertemuan;
        $data['tugas'] = $this->model('Pertemuan_model')->getTugasByPertemuan($id_pertemuan);
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $this->view("templates/navbar", $data);
        $this->view("guru/tugas", $data);
    }

    public function jawaban_refleksi($id_mapel, $id_pertemuan)
{
    $data['id_mapel'] = $id_mapel;
    $dta['id_pertemuan'] = $id_pertemuan;
    $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
    $data['jawaban'] = $this->model('Refleksi_model')->getAllJawabanByPertemuan($id_pertemuan);
    $this->view("templates/navbar", $data);
    $this->view("guru/jawaban_refleksi", $data);
}
}