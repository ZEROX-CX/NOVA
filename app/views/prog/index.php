<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Siswa</title>
    <!-- Menyertakan Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans bg-gray-100 p-5">

    <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-md p-5">
        <h2 class="text-gray-800 text-2xl font-bold border-b-2 pb-2 mt-0">
            Progress Tracking
            <?= $data['teks'] ?>
        </h2>

        <div class="bg-gray-50 rounded-md p-4 mb-5 border-l-4 border-blue-500">
            <h3 class="text-gray-600 text-lg mt-8 mb-4">Ringkasan Progress</h3>
            <?php if (!empty($data['summary'])): ?>
                <ul>
                    <?php foreach ($data['summary'] as $s): ?>
                        <li>
                            <?= ucfirst($s['tipe_aktivitas']) ?> : 
                            <?= $s['selesai'] ?>/<?= $s['total'] ?> selesai
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <div class="text-gray-500 italic text-center py-4">
                    Belum ada data progress
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-gray-50 rounded-md p-4 mb-5 border-l-4 border-blue-500">
            <h3 class="text-gray-600 text-lg mt-8 mb-4">Detail Progress</h3>
            <table class="w-full mt-3">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-3 text-left font-bold text-gray-800">Waktu</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-800">Tipe Aktivitas</th>
                        <th class="px-4 py-3 text-left font-bold text-gray-800">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['progress'])): ?>
                        <?php foreach ($data['progress'] as $p): ?>
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="px-4 py-3"><?= $p['created_at'] ?></td>
                            <td class="px-4 py-3"><?= $p['tipe_aktivitas'] ?></td>
                            <td class="px-4 py-3"><?= $p['status'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-gray-500 italic py-4">
                                Belum ada data progress
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>