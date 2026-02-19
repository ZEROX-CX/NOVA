<?php

class Home extends Controllers {
    public function index()
    {
        $this->view('home/index');
        $this->view('templates/footer');
    }
}