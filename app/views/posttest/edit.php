<?php
 $soal = $data['soal'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Edit Soal Post-Test</h2>
        <form action="<?= BASEURL ?>/posttest/update" method="post">
            <input type="hidden" name="id_posttest" value="<?= $soal['id_posttest'] ?>">
            <input type="hidden" name="id_pertemuan" value="<?= $soal['id_pertemuan'] ?>">
            
            <div class="mb-4">
                <label for="pertanyaan" class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?= htmlspecialchars($soal['pertanyaan']) ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="opsi_a" class="block text-gray-700 text-sm font-bold mb-2">Opsi A</label>
                    <input type="text" id="opsi_a" name="opsi_a" value="<?= htmlspecialchars($soal['opsi_a']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_b" class="block text-gray-700 text-sm font-bold mb-2">Opsi B</label>
                    <input type="text" id="opsi_b" name="opsi_b" value="<?= htmlspecialchars($soal['opsi_b']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_c" class="block text-gray-700 text-sm font-bold mb-2">Opsi C</label>
                    <input type="text" id="opsi_c" name="opsi_c" value="<?= htmlspecialchars($soal['opsi_c']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_d" class="block text-gray-700 text-sm font-bold mb-2">Opsi D</label>
                    <input type="text" id="opsi_d" name="opsi_d" value="<?= htmlspecialchars($soal['opsi_d']) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="jawaban_benar" class="block text-gray-700 text-sm font-bold mb-2">Jawaban Benar</label>
                <select id="jawaban_benar" name="jawaban_benar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="A" <?= ($soal['jawaban_benar'] == 'A') ? 'selected' : '' ?>>A</option>
                    <option value="B" <?= ($soal['jawaban_benar'] == 'B') ? 'selected' : '' ?>>B</option>
                    <option value="C" <?= ($soal['jawaban_benar'] == 'C') ? 'selected' : '' ?>>C</option>
                    <option value="D" <?= ($soal['jawaban_benar'] == 'D') ? 'selected' : '' ?>>D</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Soal
                </button>
                <a href="<?= BASEURL ?>/posttest/index/<?= $soal['id_pertemuan'] ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>

</body>
</html>