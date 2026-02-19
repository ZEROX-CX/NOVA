<?php

class Pertemuan_content extends Controllers {
    
    public function index($id_materi, $id_pertemuan)
    {
        $id_siswa = $_SESSION['id_siswa'];

        // sekan mengecek sudah absen atau belm
        if(isset($id_siswa))
            {
                $kehadiran = $this->model('Absen_model')->cekKehadiran($id_pertemuan, $id_siswa);
            }

        // sekan meambil data dari database
        $data['id_pertemuan'] = $id_pertemuan;
        $data['judul'] = 'Pertemuan';
        $data['pretest'] = $this->model('Pertemuan_model')->getPretestById($id_pertemuan);
        $data['sesi_absen'] = $this->model('Pertemuan_model')->getSesiByPertemuan($id_pertemuan);
        $data['mapel'] = $this->model('Pertemuan_model')->getMapel($id_materi);
        $data['pertemuan'] = $this->model('Pertemuan_model')->getPertemuanById($id_pertemuan);
        $data['tugas'] = $this->model('Pertemuan_model')->getTugasByPertemuan($id_pertemuan);
        $data['refleksi'] = $this->model('Pertemuan_model')->getRefleksiByPertemuan($id_pertemuan);
        $data['sudah_absen'] = !empty($kehadiran);
        $total_absen = $this->model('Progress_model')->countAbsenBySiswa($id_siswa);

        if ($total_absen == 3) {
                $data['unlockAchivementSiswa_teladan'] = $this->model("Achievement_model")->unlockAchivementSiswa_teladan($id_siswa, 'siswa_teladan');
        }


                // if ($total_absen == 3) {
        //     $achievementGiven = $this->model('Achievement_model')->checkAchievement($id_siswa, 'Siswa_teladan');
        //     if(!$achievementGiven){
        //         $_SESSION['toast'] = [
        //             'type' => 'success',
        //             'message' => 'Meraih Pencapaian Siswa Teladan'
        //         ];
        //     }
        // }
        if($data['sudah_absen']) {
            $data['materi'] = $this->model('Pertemuan_model')->getMateriByPertemuan($id_pertemuan);
        } else {
            $data['materi'] = [];
        }
        $this->view('templates/navbar', $data);
        $this->view('pertemuan_content/index', $data);

    }


}