<?php

class Mapel_guru extends Controllers {
    public function index()
    {
        $data['judul'] = 'Mapel ku';
        
        // Check if search form is submitted
        if (isset($_POST['cari'])) {
            $searchTerm = $_POST['search'] ?? '';
            $data['mapel'] = $this->model('Mapel_guru_model')->searchMapel($searchTerm);
            $data['mapel_guru'] = $this->model('Dashboard_model')->searchMapelByGuru($searchTerm);
        } else {
            $data['mapel'] = $this->model('Mapel_guru_model')->getAllMapel();
            $data['mapel_guru'] = $this->model('Dashboard_model')->getMapelByGuru();
        }
        
        $this->view("templates/navbar", $data);
        $this->view("mapel_guru/index", $data);
    }
}