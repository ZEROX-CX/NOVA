<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>🎯 Game True / False</h2>

<div id="box" style="font-size:20px;margin-bottom:20px;"></div>

<button onclick="jawab(true)">Benar</button>
<button onclick="jawab(false)">Salah</button>

<div id="hasil"></div>

<hr>

<!-- TOMBOL LEADERBOARD -->
<a href="<?= BASEURL ?>/Truefalse/leaderboard/<?= $id_game ?>">
    <button style="margin-top:20px;">📊 Lihat Leaderboard</button>
</a>

<script>
const pertanyaan = <?= json_encode($questions) ?>;
let index = 0;
let skor = 0;

function tampilkan() {
    if (index < pertanyaan.length) {
        document.getElementById('box').innerHTML = pertanyaan[index].pertanyaan;
    } else {
        document.getElementById('box').innerHTML =
            <b>🎉 Selesai! Skor Anda: ${skor}/${pertanyaan.length}</b>;

        kirim();
    }
}

function jawab(ans) {
    const benar = pertanyaan[index].jawaban == 1;

    if (ans === benar) {
        skor++;
        document.getElementById('hasil').innerHTML = "✅ Jawaban benar!";
    } else {
        document.getElementById('hasil').innerHTML = "❌ Jawaban salah!";
    }

    index++;
    setTimeout(tampilkan, 700);
}

function kirim() {
    fetch("<?= BASEURL ?>/Truefalse/save", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "skor=" + skor + "&id_game=<?= $id_game ?>"
    })
    .then(r => r.text())
    .then(t => {
        if (t === "OK") {
            document.getElementById("hasil").innerHTML =
                "📌 Skor berhasil disimpan!";
        }
    });
}

tampilkan();
</script>
</body>
</html>