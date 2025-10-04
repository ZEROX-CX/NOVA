<?php
include 'koneksi.php';
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM soal WHERE id=$id");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pertanyaan = $_POST['pertanyaan'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $benar = $_POST['jawaban_benar'];

    mysqli_query($conn, "UPDATE soal SET 
        pertanyaan='$pertanyaan', opsi_a='$a', opsi_b='$b', opsi_c='$c', opsi_d='$d', jawaban_benar='$benar'
        WHERE id=$id");
    header("Location: soal_list.php");
    exit;
}
?>

<h2>Edit Soal</h2>
<form method="post">
  Pertanyaan: <br>
  <textarea name="pertanyaan" required><?= $data['pertanyaan'] ?></textarea><br><br>
  Pilihan A: <input type="text" name="a" value="<?= $data['opsi_a'] ?>" required><br>
  Pilihan B: <input type="text" name="b" value="<?= $data['opsi_b'] ?>" required><br>
  Pilihan C: <input type="text" name="c" value="<?= $data['opsi_c'] ?>" required><br>
  Pilihan D: <input type="text" name="d" value="<?= $data['opsi_d'] ?>" required><br>
  Jawaban Benar:
  <select name="jawaban_benar" required>
    <?php foreach (['A','B','C','D'] as $opt) { ?>
      <option value="<?= $opt ?>" <?= $data['jawaban_benar']==$opt?'selected':'' ?>><?= $opt ?></option>
    <?php } ?>
  </select><br><br>
  <button type="submit">Update</button>
</form>
