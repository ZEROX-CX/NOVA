<?php

class Beranda extends Controllers{
    public function index()
    {
        $data['judul'] = 'Beranda';      
        $data['absen'] = $this->model('Beranda_model')->getAllAbsen();
        $data['mapel'] = $this->model('Mapel_guru_model')->getAllMapel();
        $this->view('templates/navbar', $data);
        $this->view('beranda/index', $data);
        // $this->view('templates/footer');
    }
}