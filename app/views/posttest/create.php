<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>tambah soal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Tambah Soal Post-Test Baru</h2>
        <form action="<?= BASEURL ?>/posttest/store" method="post">
            <input type="hidden" name="id_pertemuan" value="<?= $data['id_pertemuan'] ?>">
            <input type="hidden" name="id_mapel" value="<?= $data['id_mapel'] ?>">
            
            <div class="mb-4">
                <label for="pertanyaan" class="block text-gray-700 text-sm font-bold mb-2">Pertanyaan</label>
                <textarea id="pertanyaan" name="pertanyaan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="opsi_a" class="block text-gray-700 text-sm font-bold mb-2">Opsi A</label>
                    <input type="text" id="opsi_a" name="opsi_a" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_b" class="block text-gray-700 text-sm font-bold mb-2">Opsi B</label>
                    <input type="text" id="opsi_b" name="opsi_b" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_c" class="block text-gray-700 text-sm font-bold mb-2">Opsi C</label>
                    <input type="text" id="opsi_c" name="opsi_c" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="opsi_d" class="block text-gray-700 text-sm font-bold mb-2">Opsi D</label>
                    <input type="text" id="opsi_d" name="opsi_d" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
            </div>

            <div class="mb-6">
                <label for="jawaban_benar" class="block text-gray-700 text-sm font-bold mb-2">Jawaban Benar</label>
                <select id="jawaban_benar" name="jawaban_benar" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan Soal
                </button>
                <a href="<?= BASEURL ?>/posttest/index/<?= $data['id_pertemuan'] ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>

</body>
</html>