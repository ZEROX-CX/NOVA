<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pertanyaan = $_POST['pertanyaan'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $benar = $_POST['jawaban_benar'];

    mysqli_query($conn, "INSERT INTO soal (pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar)
                         VALUES ('$pertanyaan','$a','$b','$c','$d','$benar')");
    header("Location: soal_list.php");
    exit;
}
?>

<h2>Tambah Soal</h2>
<form method="post">
  Pertanyaan: <br>
  <textarea name="pertanyaan" required></textarea><br><br>
  Pilihan A: <input type="text" name="a" required><br>
  Pilihan B: <input type="text" name="b" required><br>
  Pilihan C: <input type="text" name="c" required><br>
  Pilihan D: <input type="text" name="d" required><br>
  Jawaban Benar:
  <select name="jawaban_benar" required>
    <option value="">--Pilih--</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
  </select>
  <br><br>
  <button type="submit">Simpan</button>
</form>
