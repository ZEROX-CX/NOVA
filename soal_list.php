<?php
include 'koneksi.php';

// Hapus soal
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM soal WHERE id=$id");
    header("Location: soal_list.php");
    exit;
}

// Ambil semua soal
$result = mysqli_query($conn, "SELECT * FROM soal");
?>

<h2>Daftar Soal</h2>
<a href="soal_tambah.php">Tambah Soal</a>
<table border="1" cellpadding="5" cellspacing="0">
  <tr>
    <th>No</th><th>Pertanyaan</th><th>Jawaban Benar</th><th>Aksi</th>
  </tr>
  <?php $no=1; while($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
      <td><?= $no++ ?></td>
      <td><?= htmlspecialchars($row['pertanyaan']) ?></td>
      <td><?= $row['jawaban_benar'] ?></td>
      <td>
        <a href="soal_edit.php?id=<?= $row['id'] ?>">Edit</a> | 
        <a href="soal_list.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus soal ini?')">Hapus</a>
      </td>
    </tr>
  <?php } ?>
</table>
