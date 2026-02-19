<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>📊 Leaderboard True/False</h2>

<table border="1" cellpadding="8" cellspacing="0">
<tr>
    <th>Nama Siswa</th>
    <th>Skor</th>
    <th>Waktu</th>
</tr>

<?php foreach ($list as $row): ?>
<tr>
    <td><?= $row['nama'] ?></td>
    <td><?= $row['skor'] ?></td>
    <td><?= $row['waktu'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<br>

<a href="<?= BASEURL ?>/Truefalse/index/<?= $id_game ?>">
    <button>⬅ Kembali ke Game</button>
</a>
</body>
</html>