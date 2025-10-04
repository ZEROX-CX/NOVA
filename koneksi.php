<?php
$conn = mysqli_connect("localhost", "root", "", "db_kuis");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
