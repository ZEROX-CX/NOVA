<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<title>Admin Drag & Drop</title>
</head>

<body class="bg-gray-100 min-h-screen px-3 py-6">

<main class="max-w-6xl mx-auto bg-white p-5 md:p-8 rounded-xl shadow-lg">

<!-- HEADER -->
<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
    <h1 class="text-2xl font-bold text-[#00007F]">
        Admin Drag & Drop Game
    </h1>

    <div class="flex gap-3">
        <a href="<?= BASEURL ?>/Dragdrop/index"
           class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm">
            Play
        </a>
        <a href="<?= BASEURL ?>/Dragdrop/leaderboard"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
            Leaderboard
        </a>
    </div>
</div>

<!-- ADD GAME -->
<div class="mb-8 border rounded-xl p-4 bg-gray-50">
    <h3 class="font-semibold text-lg mb-3">Tambah Game</h3>
    <form method="POST" class="flex flex-col md:flex-row gap-3">
        <input type="text" name="judul" placeholder="Judul game..."
               class="flex-1 border rounded-lg p-3" required>
        <button type="submit" name="add_game"
                class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Tambah
        </button>
    </form>
</div>

<!-- LIST GAMES -->

<div class="mb-10 border rounded-xl p-5 bg-gray-50">
<?php foreach ($games as $g): ?>
    <!-- GAME HEADER -->
    <div class="flex flex-col lg:flex-row lg:justify-between gap-4 mb-6">
        <form method="POST" class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="judul" value="<?= htmlentities($g['judul']) ?>"
                   class="border rounded-lg p-2 bg-white">
            <button type="submit" name="edit_game"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Update
            </button>
        </form>

        <div class="flex gap-2">
            <button onclick="confirmDeleteGame(<?= $g['id_game'] ?>)"
                    class="px-4 py-2 bg-red-600 text-white rounded-lg">
                Hapus
            </button>
            <a href="<?= BASEURL ?>/Dragdrop/index?id=<?= $g['id_game'] ?>"
               class="px-4 py-2 bg-gray-200 rounded-lg">
                Lihat
            </a>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        <!-- AREAS -->
        <div>
            <h4 class="font-semibold text-blue-700 mb-3">Areas</h4>

            <form method="POST" class="flex flex-col sm:flex-row gap-2 mb-4">
                <input type="hidden" name="id_game" value="<?= $g['id_game'] ?>">
                <input type="text" name="nama_area" placeholder="Nama area..."
                       class="flex-1 p-2 border rounded-lg" required>
                <button type="submit" name="add_area"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Tambah
                </button>
            </form>

            <?php
            $db = new Database();
            $db->query("SELECT * FROM drag_drop_area WHERE id_game = :id");
            $db->bind(":id", $g['id_game']);
            $areas = $db->resultSet();
            ?>

            <ul class="space-y-2">
                <?php foreach($areas as $a): ?>
                <li class="flex flex-col sm:flex-row gap-2">
                    <form method="POST" class="flex flex-1 gap-2">
                        <input type="hidden" name="id_area" value="<?= $a['id_area'] ?>">
                        <input type="text" name="nama_area"
                               value="<?= htmlentities($a['nama_area']) ?>"
                               class="flex-1 p-2 border rounded-lg">
                        <button type="submit" name="edit_area"
                                class="px-3 bg-blue-600 text-white rounded-lg">
                            Update
                        </button>
                    </form>
                    <button onclick="confirmDeleteArea(<?= $a['id_area'] ?>)"
                            class="px-3 py-2 bg-red-600 text-white rounded-lg">
                        Hapus
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- ITEMS -->
        <div>
            <h4 class="font-semibold text-blue-700 mb-3">Items</h4>

            <form method="POST" class="space-y-2 mb-4">
                <input type="hidden" name="id_game" value="<?= $g['id_game'] ?>">
                <input type="text" name="nama_item" placeholder="Nama item..."
                       class="w-full p-2 border rounded-lg" required>

                <select name="correct_area_id" class="w-full p-2 border rounded-lg">
                    <option value="">Pilih Area Benar</option>
                    <?php foreach($areas as $a): ?>
                    <option value="<?= $a['id_area'] ?>"><?= htmlentities($a['nama_area']) ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" name="add_item"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg">
                    Tambah Item
                </button>
            </form>

            <?php
            $db2 = new Database();
            $db2->query("SELECT * FROM drag_drop_item WHERE id_game = :id");
            $db2->bind(":id", $g['id_game']);
            $items = $db2->resultSet();
            ?>

            <ul class="space-y-2">
                <?php foreach($items as $it): ?>
                <li class="flex flex-col sm:flex-row gap-2">
                    <form method="POST" class="flex flex-1 gap-2">
                        <input type="hidden" name="id_item" value="<?= $it['id_item'] ?>">
                        <input type="text" name="nama_item"
                               value="<?= htmlentities($it['nama_item']) ?>"
                               class="flex-1 p-2 border rounded-lg">

                        <select name="correct_area_id" class="p-2 border rounded-lg">
                            <option value="">Area Benar</option>
                            <?php foreach($areas as $a): ?>
                            <option value="<?= $a['id_area'] ?>"
                                <?= $it['correct_area_id']==$a['id_area']?'selected':'' ?>>
                                <?= htmlentities($a['nama_area']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>

                        <button type="submit" name="edit_item"
                                class="px-3 bg-blue-600 text-white rounded-lg">
                            Update
                        </button>
                    </form>
                    <button onclick="confirmDeleteItem(<?= $it['id_item'] ?>)"
                            class="px-3 py-2 bg-red-600 text-white rounded-lg">
                        Hapus
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
</div>
<?php endforeach; ?>

</main>
</body>
</html>