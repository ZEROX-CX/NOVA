<?php
include "../service/database.php";

$id_tugas = $_GET['id_tugas'] ?? null;
$id_materi = $_GET['id_materi'] ?? null;

if (!$id_tugas) {
    die("ID tugas tidak ditemukan.");
}

mysqli_query($db, "DELETE FROM tugas WHERE id_tugas = $id_tugas");
header("Location: index.php?id=$id_materi");
exit;
