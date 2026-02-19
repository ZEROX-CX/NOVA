<?php

class Mapelku extends Controllers {
    public function index()
    {
        $data['judul'] = 'Mapel ku';
        $data['materi'] = $this->model('Mapel_guru_model')->getAllMateri();
        $this->view('templates/navbar');
        $this->view('mapelku/index', $data);
    }

    public function deleteMateri($id)
    {
        $this->model('Mapelku_model')->deleteMateri($id);
        header('Location: ' . BASEURL . '/mapelku');
        exit;
    }
}