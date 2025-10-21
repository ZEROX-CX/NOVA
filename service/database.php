<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sekolah";

$db = mysqli_connect($host, $username, $password, $database);
if($db->connect_error) {
    die("koneksji gagal");
}
?>