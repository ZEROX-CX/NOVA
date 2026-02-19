<?php
// Pastikan session dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah ada parameter ID di URL
if (isset($_GET['id'])) {
    $id_materi = $_GET['id'];

    // Lakukan update status di session
    $_SESSION["viewed"][$id_materi] = true;

    // Setelah update, arahkan ke halaman tujuan akhir
    $tujuan_akhir = '/mapel/index/' . $id_materi;
    header("Location: " . $tujuan_akhir);
    exit(); // Penting untuk menghentikan eksekusi script setelah redirect

} else {
    // Jika tidak ada ID, bisa arahkan ke halaman error atau halaman utama
    header("Location: /mapel_guru"); // Arahkan kembali ke daftar materi
    exit();
}
?>