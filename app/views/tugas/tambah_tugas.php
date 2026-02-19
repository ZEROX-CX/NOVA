<?php
include "../service/database.php";

$id_materi = $_GET['id_materi'] ?? null;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_tugas = $_POST['judul_tugas'];
    $deskripsi = $_POST['deskripsi'];
    $file_name = null;

    // Upload file jika ada
    if (!empty($_FILES['file_tugas']['name'])) {
        $file_name = time() . "_" . basename($_FILES['file_tugas']['name']);
        $target_path = "../uploads/" . $file_name;
        move_uploaded_file($_FILES['file_tugas']['tmp_name'], $target_path);
    }

    $query = "INSERT INTO tugas (id_materi, judul_tugas, deskripsi, file_tugas)
              VALUES ('$id_materi', '$judul_tugas', '$deskripsi', '$file_name')";
    if (mysqli_query($db, $query)) {
        header("Location: index.php?id=$id_materi");
        exit;
    } else {
        $message = "Gagal menambahkan tugas: " . mysqli_error($db);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Tugas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4">Tambah Tugas</h2>
    <?php if ($message): ?>
      <p class="text-red-500 mb-4"><?= $message ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block font-medium mb-1">Judul Tugas</label>
        <input type="text" name="judul_tugas" class="w-full border rounded p-2" required>
      </div>
      <div>
        <label class="block font-medium mb-1">Deskripsi</label>
        <textarea name="deskripsi" rows="4" class="w-full border rounded p-2"></textarea>
      </div>
      <div>
        <label class="block font-medium mb-1">Upload File (opsional)</label>
        <input type="file" name="file_tugas" class="w-full border rounded p-2">
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
      <a href="index.php?id=<?= $id_materi ?>" class="text-gray-600 ml-3">Batal</a>
    </form>
  </div>
</body>
</html>