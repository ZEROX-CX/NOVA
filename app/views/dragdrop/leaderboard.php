<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Leaderboard</title>
</head>

<body class="bg-gray-50 min-h-screen py-10">

<main class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-md">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h1 class="text-2xl font-semibold text-[#00007F]">
            Leaderboard Drag & Drop
        </h1>

        <div class="flex gap-3">
            <a href="<?= BASEURL ?>/Dragdrop/index"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Play
            </a>

            <a href="<?= BASEURL ?>/Dragdrop/admin"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                Admin
            </a>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-blue-200 text-black">
                <tr>
                    <th class="p-3 text-left font-semibold">Siswa</th>
                    <th class="p-3 text-left font-semibold">Game</th>
                    <th class="p-3 text-center font-semibold">Skor</th>
                    <th class="p-3 text-left font-semibold">Tanggal</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($scores)): ?>
                    <?php foreach ($scores as $row): ?>
                    <tr class="border-t hover:bg-gray-100 transition">
                        <td class="p-3"><?= $row['nama_siswa'] ?></td>
                        <td class="p-3"><?= $row['judul'] ?></td>
                        <td class="p-3 text-center font-semibold">
                            <?= $row['skor'] ?>
                        </td>
                        <td class="p-3"><?= $row['tanggal'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Belum ada data leaderboard.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</main>

</body>
</html>