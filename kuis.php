<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = mysqli_query($conn, "SELECT * FROM soal");
    $jumlah_soal = mysqli_num_rows($result);
    $benar = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        if (isset($_POST["soal_$id"]) && $_POST["soal_$id"] == $row['jawaban_benar']) {
            $benar++;
        }
    }

    $skor = ($benar / $jumlah_soal) * 100;
    echo "<h2>Hasil Kuis</h2>";
    echo "Benar: $benar dari $jumlah_soal soal<br>";
    echo "Nilai: $skor";
    echo "<br><br><a href='kuis.php'>Ulangi</a>";
} else {
    $result = mysqli_query($conn, "SELECT * FROM soal");
    if (mysqli_num_rows($result) == 0) {
        echo "Belum ada soal.";
        exit;
    }
    echo "<form method='post'>";
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<p>$no. {$row['pertanyaan']}</p>";
        foreach (['A','B','C','D'] as $opt) {
            $opsi_text = $row["opsi_" . strtolower($opt)];
            echo "<label><input type='radio' name='soal_{$row['id']}' value='$opt'> $opt. $opsi_text</label><br>";
        }
        $no++;
    }
    echo "<br><button type='submit'>Kirim Jawaban</button></form>";
}
?>
