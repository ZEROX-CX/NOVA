<?php
$refleksi = $data['refleksi'];
$pertemuan = $data['pertemuan'];
$mapel = $pertemuan['mapel'] ?? "Mapel";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refleksi Pembelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto max-w-7xl px-4 pt-4">
    <div class="flex flex-col md:flex-row gap-6">

        <!-- Sidebar -->
        <aside class="hidden md:block w-64 bg-white shadow-md rounded-lg h-fit">
            <!-- isi sidebar -->
        </aside>

        <!-- Main -->
        <main class="flex-1 bg-white shadow-md rounded-lg p-4 sm:p-6">
            <p class="text-xs sm:text-sm text-gray-500 mb-2">
                Mapel > <?= htmlspecialchars($mapel) ?> > Refleksi
            </p>

            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6">
                Refleksi <?= htmlspecialchars($mapel) ?>
            </h1>

            <form id="refleksiForm" action="<?= BASEURL ?>/refleksi/submit" method="POST" class="space-y-6">
                <input type="hidden" name="id_pertemuan" value="<?= $pertemuan['id_pertemuan'] ?>">

                <?php foreach ($refleksi as $r): ?>
                <div class="refleksi-item">
                    <label class="block text-sm sm:text-base text-gray-700 font-medium mb-2">
                        <?= htmlspecialchars($r['pertanyaan']) ?>
                    </label>

                    <textarea 
                        name="jawaban[<?= $r['id_refleksi'] ?>]"
                        rows="4"
                        class="refleksi-input w-full border border-gray-300 rounded-lg p-3 text-sm sm:text-base
                               focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                    ></textarea>

                    <p class="text-red-500 text-sm mt-1 hidden error-text">
                        Jawaban tidak boleh kosong.
                    </p>
                </div>
                <?php endforeach; ?>

                <div class="pt-6 flex flex-col sm:flex-row gap-4">
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg 
                               hover:bg-indigo-700 transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Kirim Refleksi
                    </button>

                    <a href="<?= BASEURL ?>/guru/jawaban_refleksi/<?= $data['id_mapel'] ?>/<?= $pertemuan['id_pertemuan'] ?>" 
                       class="text-center bg-gray-100 text-gray-700 font-semibold px-6 py-3 
                              rounded-lg hover:bg-gray-200 transition">
                        Lihat Jawaban Murid
                    </a>
                </div>
            </form>
        </main>

    </div>
</div>

<!-- VALIDASI + UX -->
<script>
const form = document.getElementById('refleksiForm');
const submitBtn = document.getElementById('submitBtn');

form.addEventListener('submit', function (e) {
    let valid = true;
    let firstError = null;

    document.querySelectorAll('.refleksi-item').forEach(item => {
        const textarea = item.querySelector('.refleksi-input');
        const errorText = item.querySelector('.error-text');

        if (textarea.value.trim() === '') {
            valid = false;
            textarea.classList.add('border-red-500', 'ring-1', 'ring-red-400');
            errorText.classList.remove('hidden');

            if (!firstError) firstError = textarea;
        } else {
            textarea.classList.remove('border-red-500', 'ring-1', 'ring-red-400');
            errorText.classList.add('hidden');
        }
    });

    if (!valid) {
        e.preventDefault();
        firstError.focus();
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    // Loading UX
    submitBtn.disabled = true;
    submitBtn.innerText = 'Mengirim...';
});
</script>

</body>
</html