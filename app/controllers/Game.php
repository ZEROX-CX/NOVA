<?php

class Game extends Controllers{
    public function index()
    {
        $this->view('game/index');
    }

    public function tes()
    {
        $this->view('game/tes');
    }
}