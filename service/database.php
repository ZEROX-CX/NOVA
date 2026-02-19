<?php
 $host = "localhost";
 $username = "root";
 $password = "";
 $database = "sekolah";

// Membuat koneksi dengan gaya Objek-Oriented
 $db = new mysqli($host, $username, $password, $database);

// Cek koneksi dengan gaya OOP
if ($db->connect_error) {
    // Hentikan skrip dan tampilkan pesan error
    die("Koneksi gagal: " . $db->connect_error);
}
?>