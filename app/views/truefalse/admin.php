<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Kelola Game True / False</h2>

<h3>Tambah Pertanyaan</h3>
<form method="POST" action="<?= BASEURL ?>/Truefalse/add">
    <input type="hidden" name="id_game" value="<?= $game['id_game'] ?>">
    <label>Pertanyaan:</label><br>
    <input type="text" name="pertanyaan" required><br><br>

    <label>Jawaban:</label>
    <select name="jawaban">
        <option value="1">Benar</option>
        <option value="0">Salah</option>
    </select>

    <button type="submit">Tambah</button>
</form>

<h3>Daftar Pertanyaan</h3>

<table>
<tr>
    <th>ID</th>
    <th>Pertanyaan</th>
    <th>Jawaban</th>
    <th>Aksi</th>
</tr>

<?php foreach($questions as $q): ?>
<tr>
    <form method="POST" action="<?= BASEURL ?>/Truefalse/update">
        <td><?= $q['id_question'] ?></td>

        <td><input type="text" name="pertanyaan" value="<?= htmlspecialchars($q['pertanyaan']) ?>"></td>

        <td>
            <select name="jawaban">
                <option value="1" <?= $q['jawaban'] ? 'selected' : '' ?>>Benar</option>
                <option value="0" <?= !$q['jawaban'] ? 'selected' : '' ?>>Salah</option>
            </select>
        </td>

        <td>
            <input type="hidden" name="id_question" value="<?= $q['id_question'] ?>">
            <button>💾 Simpan</button>

            <a href="<?= BASEURL ?>/Truefalse/delete/<?= $q['id_question'] ?>"
               onclick="return confirm('Hapus pertanyaan?')">🗑 Hapus</a>
        </td>
    </form>
</tr>
<?php endforeach; ?>
</table>

<p>
    <strong>Link main siswa:</strong><br>
    <a href="<?= BASEURL ?>/Truefalse/play/<?= $game['id_game'] ?>">MAIN GAME</a>
</p>

</body>
</html>