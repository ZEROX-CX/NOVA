<?php
    include "service/database.php";


    if(isset($_GET["kirim"])) {
        $jawaban = $_GET["jawaban"];

        if($jawaban == "benar"){
            echo "anda memilih jawaban yang benar";
        } else {
            echo 'anda memilih jawaban yang salah';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="soal.php" method="GET"> 
        <label>soal satu</label> <br>
        <input type="radio" name="jawaban" >A.
        <input type="radio" name="jawaban" >B
        <input type="radio" name="jawaban" value="benar">C
        <button type="submit" value="kirim" name="kirim">kirim</button>
    </form>
</body>
</html>